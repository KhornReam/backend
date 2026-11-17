<?php

use App\Http\Api\AttendanceController;
use App\Http\Api\AuditLogController;
use App\Http\Api\SchoolClassController;
use App\Http\Api\StudentController;
use App\Http\Api\SubjectController;
use App\Http\Api\TeacherController;
use Illuminate\Support\Facades\Route;

Route::apiResource('students', StudentController::class);
Route::apiResource('classes', SchoolClassController::class);
Route::apiResource('teachers', TeacherController::class);
Route::apiResource('subjects', SubjectController::class);
Route::apiResource('attendances', AttendanceController::class);
Route::post('attendances/batch', [AttendanceController::class, 'batchStore']);
Route::apiResource('audit-logs', AuditLogController::class)->only(['index', 'store', 'destroy']);
Route::post('audit-logs/clear', [AuditLogController::class, 'clear']);
