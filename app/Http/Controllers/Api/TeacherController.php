<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;

class TeacherController extends Controller
{
    public function index()
    {
        return TeacherResource::collection(Teacher::query()->orderBy('name')->get());
    }

    public function store(StoreTeacherRequest $request): JsonResponse
    {
        return (new TeacherResource(Teacher::create($request->validated())))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Teacher $teacher): TeacherResource
    {
        return new TeacherResource($teacher);
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher): TeacherResource
    {
        $teacher->update($request->validated());

        return new TeacherResource($teacher->fresh());
    }

    public function destroy(Teacher $teacher): JsonResponse
    {
        $teacher->delete();

        return response()->json(['message' => 'Teacher deleted successfully.']);
    }
}
