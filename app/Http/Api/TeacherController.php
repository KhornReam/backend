<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Teacher::query()->orderBy('id')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employee_number' => ['nullable', 'string', 'max:50', 'unique:teachers,employee_number'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:teachers,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'specialization' => ['nullable', 'string', 'max:255'],
        ]);

        $teacher = Teacher::create($validated);

        return response()->json($teacher, 201);
    }

    public function show(Teacher $teacher): JsonResponse
    {
        return response()->json($teacher);
    }

    public function update(Request $request, Teacher $teacher): JsonResponse
    {
        $validated = $request->validate([
            'employee_number' => ['sometimes', 'nullable', 'string', 'max:50', 'unique:teachers,employee_number,'.$teacher->id],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255', 'unique:teachers,email,'.$teacher->id],
            'phone' => ['sometimes', 'nullable', 'string', 'max:30'],
            'specialization' => ['sometimes', 'nullable', 'string', 'max:255'],
        ]);

        $teacher->update($validated);

        return response()->json($teacher->fresh());
    }

    public function destroy(Teacher $teacher): JsonResponse
    {
        $teacher->delete();

        return response()->json(['message' => 'Teacher deleted successfully.']);
    }
}
