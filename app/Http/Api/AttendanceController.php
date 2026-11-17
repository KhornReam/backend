<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Attendance::query()->with(['student', 'schoolClass']);

        if ($request->filled('date')) {
            $query->where('date', $request->input('date'));
        }

        if ($request->filled('class_name')) {
            $query->where('class_name', $request->input('class_name'));
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('class_name', 'like', "%{$search}%")
                  ->orWhere('remarks', 'like', "%{$search}%");
            });
        }

        return response()->json($query->orderByDesc('date')->orderBy('student_name')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => ['nullable', 'integer'],
            'student_name' => ['required', 'string', 'max:255'],
            'school_class_id' => ['nullable', 'integer'],
            'class_name' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'check_in_time' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'string', 'in:Present,Late,Absent,Excused'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $attendance = Attendance::create($validated);

        return response()->json($attendance, 201);
    }

    public function batchStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'records' => ['required', 'array'],
            'records.*.student_id' => ['nullable', 'integer'],
            'records.*.student_name' => ['required', 'string', 'max:255'],
            'records.*.school_class_id' => ['nullable', 'integer'],
            'records.*.class_name' => ['nullable', 'string', 'max:255'],
            'records.*.date' => ['required', 'date'],
            'records.*.check_in_time' => ['nullable', 'string', 'max:50'],
            'records.*.status' => ['required', 'string', 'in:Present,Late,Absent,Excused'],
            'records.*.remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $created = [];
        foreach ($validated['records'] as $record) {
            $created[] = Attendance::updateOrCreate(
                [
                    'student_name' => $record['student_name'],
                    'date' => $record['date'],
                ],
                $record
            );
        }

        return response()->json(['data' => $created, 'count' => count($created)]);
    }

    public function show(Attendance $attendance): JsonResponse
    {
        return response()->json($attendance->load(['student', 'schoolClass']));
    }

    public function update(Request $request, Attendance $attendance): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => ['nullable', 'integer'],
            'student_name' => ['sometimes', 'required', 'string', 'max:255'],
            'school_class_id' => ['nullable', 'integer'],
            'class_name' => ['nullable', 'string', 'max:255'],
            'date' => ['sometimes', 'required', 'date'],
            'check_in_time' => ['nullable', 'string', 'max:50'],
            'status' => ['sometimes', 'required', 'string', 'in:Present,Late,Absent,Excused'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $attendance->update($validated);

        return response()->json($attendance->fresh());
    }

    public function destroy(Attendance $attendance): JsonResponse
    {
        $attendance->delete();

        return response()->json(['message' => 'Attendance record removed successfully.']);
    }
}
