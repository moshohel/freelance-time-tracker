<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimeLogRequest;
use App\Http\Requests\UpdateTimeLogRequest;
use App\Http\Resources\TimeLogResource;
use App\Services\TimeLog\TimeLogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class TimeLogController extends Controller
{
    protected TimeLogServiceInterface $timeLogService;

    public function __construct(TimeLogServiceInterface $timeLogService)
    {
        $this->timeLogService = $timeLogService;
    }

    public function index(): JsonResponse
    {
        try {
            $logs = $this->timeLogService->getUserLogs(Auth::id());
            if ($logs->isEmpty()) {
                return response()->json(['message' => 'No logs for this user found'], 404);
            }
            return response()->json(TimeLogResource::collection($logs), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching logs: ' . $e->getMessage()], 500);
        }
    }

    public function store(TimeLogRequest $request): JsonResponse
    {
        try {
            $log = $this->timeLogService->manualEntry($request->validated());
            return response()->json(new TimeLogResource($log), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error starting log: ' . $e->getMessage()], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $log = $this->timeLogService->getUserLogs(Auth::id())->firstWhere('id', $id);
            if (!$log) {
                return response()->json(['message' => 'Log not found'], 404);
            }
            return response()->json(new TimeLogResource($log), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching log: ' . $e->getMessage()], 500);
        }
    }

    public function update(UpdateTimeLogRequest $request, int $id): JsonResponse
    {
        try {
            $log = $this->timeLogService->getUserLogs(Auth::id())->firstWhere('id', $id);
            if (!$log) {
                return response()->json(['message' => 'Log not found'], 404);
            }
            $log = $this->timeLogService->updateLog($id, $request->validated());
            return response()->json(new TimeLogResource($log), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching log: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->timeLogService->deleteLog($id);
            if (!$deleted) {
                return response()->json(['message' => 'Log not found'], 404);
            }
            return response()->json(['message' => 'Log Deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching log: ' . $e->getMessage()], 500);
        }
    }

    public function start(TimeLogRequest $request): JsonResponse
    {
        try {
            $log = $this->timeLogService->startLog($request->only(['project_id', 'tag']));
            return response()->json(new TimeLogResource($log), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error starting Log:', 'error' => $e->getMessage()], 500);
        }
    }

    public function end(int $id): JsonResponse
    {
        try {
            $log = $this->timeLogService->getUserLogs(Auth::id())->firstWhere('id', $id);
            if (!$log) {
                return response()->json(['message' => 'Log not found'], 404);
            }
            if ($log->end_time) {
                return response()->json(['message' => 'Log already ended'], 400);
            }
            $log = $this->timeLogService->endLog($id);
            return response()->json(new TimeLogResource($log), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching log: ' . $e->getMessage()], 500);
        }
    }

    public function filter(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['user_id', 'project_id', 'client_id', 'from', 'to']);
            $logs = $this->timeLogService->getLogsByFilter($filters);
            if ($logs->isEmpty()) {
                return response()->json(['message' => 'No logs found for the given filters'], 404);
            }
            return response()->json(TimeLogResource::collection($logs), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching logs: ' . $e->getMessage()], 500);
        }
    }
}
