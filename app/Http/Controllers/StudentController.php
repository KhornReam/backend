
<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    /**
     * Get all students from the database.
     */
    public function index(): JsonResponse
    {
        // Retrieve all records from the students table.
        $students = Student::all();

        // Return the student records as JSON for Vue.js.
        return response()->json($students);
    }
}
