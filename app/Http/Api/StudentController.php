<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Student::query()->with('schoolClass:id,grade,section')->orderBy('id')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'gender' => ['nullable', 'string', Rule::in(['Male', 'Female'])],
            'course' => ['nullable', 'string', 'max:255'],
            'school_class_id' => ['nullable', 'integer', Rule::exists('school_classes', 'id')],
        ]);

        $student = Student::create($validated)->load('schoolClass:id,grade,section');

        return response()->json($student, 201);
    }

    public function show(Student $student): JsonResponse
    {
        return response()->json($student->load('schoolClass:id,grade,section'));
    }

    public function update(Request $request, Student $student): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255', 'unique:students,email,'.$student->id],
            'gender' => ['sometimes', 'nullable', 'string', Rule::in(['Male', 'Female'])],
            'course' => ['sometimes', 'nullable', 'string', 'max:255'],
            'school_class_id' => ['sometimes', 'nullable', 'integer', Rule::exists('school_classes', 'id')],
        ]);

        $student->update($validated);

        return response()->json($student->fresh()->load('schoolClass:id,grade,section'));
    }

    public function destroy(Student $student): JsonResponse
    {
        $student->delete();

        return response()->json(['message' => 'Student deleted successfully.']);
    }
}
