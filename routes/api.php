<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', DashboardController::class);
Route::apiResource('students', StudentController::class);
Route::apiResource('teachers', TeacherController::class);
