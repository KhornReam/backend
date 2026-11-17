<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = AuditLog::query()->orderByDesc('created_at');

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('resource', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $logs = $query->limit(100)->get();

        return response()->json($logs);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_name' => ['nullable', 'string', 'max:255'],
            'user_email' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:100'],
            'action' => ['required', 'string', 'max:500'],
            'category' => ['required', 'string', 'max:100'],
            'resource' => ['nullable', 'string', 'max:255'],
            'ip_address' => ['nullable', 'string', 'max:50'],
            'status' => ['nullable', 'string', 'max:50'],
        ]);

        $log = AuditLog::create([
            'user_name' => $validated['user_name'] ?? 'Administrator',
            'user_email' => $validated['user_email'] ?? 'admin@school.edu',
            'role' => $validated['role'] ?? 'Super Administrator',
            'action' => $validated['action'],
            'category' => $validated['category'],
            'resource' => $validated['resource'] ?? null,
            'ip_address' => $validated['ip_address'] ?? $request->ip() ?? '127.0.0.1',
            'status' => $validated['status'] ?? 'Success',
        ]);

        return response()->json($log, 201);
    }

    public function destroy(AuditLog $auditLog): JsonResponse
    {
        $auditLog->delete();

        return response()->json(['message' => 'Audit log entry removed.']);
    }

    public function clear(Request $request): JsonResponse
    {
        $days = (int) $request->input('days', 0);
        if ($days > 0) {
            AuditLog::where('created_at', '<', now()->subDays($days))->delete();
            return response()->json(['message' => "Logs older than {$days} days cleared."]);
        }

        AuditLog::truncate();
        return response()->json(['message' => 'All audit logs cleared.']);
    }
}
