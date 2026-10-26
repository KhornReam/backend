<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_index_returns_student_resources(): void
    {
        Student::query()->create([
            'name' => 'Alex Rivera',
            'email' => 'alex@example.test',
            'course' => 'Science',
        ]);

        $this->getJson('/api/students')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Alex Rivera')
            ->assertJsonPath('data.0.email', 'alex@example.test');
    }

    public function test_valid_student_payload_creates_record_and_returns_201(): void
    {
        $payload = [
            'name' => 'Alex Rivera',
            'email' => 'alex@example.test',
            'course' => 'Science',
        ];

        $this->postJson('/api/students', $payload)
            ->assertCreated()
            ->assertJsonPath('data.name', 'Alex Rivera');

        $this->assertDatabaseHas('students', $payload);
    }

    public function test_student_create_rejects_missing_name_and_email(): void
    {
        $this->postJson('/api/students', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email']);
    }

    public function test_student_can_be_updated_and_deleted(): void
    {
        $student = Student::query()->create([
            'name' => 'Alex Rivera',
            'email' => 'alex@example.test',
            'course' => 'Science',
        ]);

        $this->putJson("/api/students/{$student->id}", ['course' => 'Mathematics'])
            ->assertOk()
            ->assertJsonPath('data.course', 'Mathematics');

        $this->assertDatabaseHas('students', ['id' => $student->id, 'course' => 'Mathematics']);

        $this->deleteJson("/api/students/{$student->id}")->assertOk();

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }
}
