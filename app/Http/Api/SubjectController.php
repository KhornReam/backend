<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Subject::query()->orderBy('id')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:subjects,code'],
            'grade' => ['required', 'string', 'max:100'],
            'teacher' => ['nullable', 'string', 'max:255'],
            'credits' => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $subject = Subject::create($validated);

        return response()->json($subject, 201);
    }

    public function show(Subject $subject): JsonResponse
    {
        return response()->json($subject);
    }

    public function update(Request $request, Subject $subject): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'code' => ['sometimes', 'required', 'string', 'max:50', 'unique:subjects,code,'.$subject->id],
            'grade' => ['sometimes', 'required', 'string', 'max:100'],
            'teacher' => ['nullable', 'string', 'max:255'],
            'credits' => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $subject->update($validated);

        return response()->json($subject->fresh());
    }

    public function destroy(Subject $subject): JsonResponse
    {
        $subject->delete();

        return response()->json(['message' => 'Subject deleted successfully.']);
    }
}
