<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'students' => Student::query()->count(),
            'teachers' => Teacher::query()->count(),
            'classes' => SchoolClass::query()->count(),
            'subjects' => Subject::query()->count(),
        ]);
    }
}
