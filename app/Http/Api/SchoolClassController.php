<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SchoolClassController extends Controller
{
    public function index(): JsonResponse
    {
        $classes = SchoolClass::query()
            ->withCount('students')
            ->orderBy('grade')
            ->orderBy('section')
            ->get();

        return response()->json($classes);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'grade' => ['required', 'integer', 'min:1', 'max:12'],
            'section' => [
                'required',
                'string',
                'max:10',
                'regex:/^[A-Z0-9]+$/',
                Rule::unique('school_classes', 'section')->where(fn (Builder $query): Builder => $query->where('grade', $request->input('grade'))),
            ],
        ]);

        $schoolClass = SchoolClass::create($validated);

        return response()->json($schoolClass->loadCount('students'), 201);
    }

    public function show(SchoolClass $class): JsonResponse
    {
        return response()->json($class->loadCount('students'));
    }

    public function update(Request $request, SchoolClass $class): JsonResponse
    {
        $validated = $request->validate([
            'grade' => ['sometimes', 'required', 'integer', 'min:1', 'max:12'],
            'section' => ['sometimes', 'required', 'string', 'max:10', 'regex:/^[A-Z0-9]+$/'],
        ]);

        $grade = (int) ($validated['grade'] ?? $class->grade);
        $section = $validated['section'] ?? $class->section;

        $duplicateClass = SchoolClass::query()
            ->where('grade', $grade)
            ->where('section', $section)
            ->whereKeyNot($class->id)
            ->exists();

        if ($duplicateClass) {
            throw ValidationException::withMessages([
                'section' => ['That section already exists in this grade.'],
            ]);
        }

        $class->update($validated);

        return response()->json($class->fresh()->loadCount('students'));
    }

    public function destroy(SchoolClass $class): JsonResponse
    {
        $class->delete();

        return response()->json(['message' => 'Class deleted successfully.']);
    }
}
