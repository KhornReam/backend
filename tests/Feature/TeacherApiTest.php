<?php

namespace Tests\Feature;

use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_index_returns_teacher_resources(): void
    {
        Teacher::query()->create([
            'name' => 'Taylor Morgan',
            'email' => 'taylor@example.test',
            'specialization' => 'Mathematics',
        ]);

        $this->getJson('/api/teachers')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Taylor Morgan')
            ->assertJsonPath('data.0.specialization', 'Mathematics');
    }

    public function test_valid_teacher_payload_creates_record_and_returns_201(): void
    {
        $payload = [
            'name' => 'Taylor Morgan',
            'email' => 'taylor@example.test',
            'specialization' => 'Mathematics',
        ];

        $this->postJson('/api/teachers', $payload)
            ->assertCreated()
            ->assertJsonPath('data.name', 'Taylor Morgan');

        $this->assertDatabaseHas('teachers', $payload);
    }

    public function test_teacher_create_rejects_missing_name(): void
    {
        $this->postJson('/api/teachers', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_teacher_can_be_updated_and_deleted(): void
    {
        $teacher = Teacher::query()->create([
            'name' => 'Taylor Morgan',
            'email' => 'taylor@example.test',
            'specialization' => 'Mathematics',
        ]);

        $this->putJson("/api/teachers/{$teacher->id}", ['specialization' => 'Physics'])
            ->assertOk()
            ->assertJsonPath('data.specialization', 'Physics');

        $this->assertDatabaseHas('teachers', ['id' => $teacher->id, 'specialization' => 'Physics']);

        $this->deleteJson("/api/teachers/{$teacher->id}")->assertOk();

        $this->assertDatabaseMissing('teachers', ['id' => $teacher->id]);
    }
}
