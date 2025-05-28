<?php

namespace App\Services\TimeLog;

use App\Models\TimeLog;
use App\Repositories\TimeLog\TimeLogRepositoryInterface;
use Illuminate\Support\Collection;
use App\Services\TimeLog\TimeLogServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TimeLogService implements TimeLogServiceInterface
{
    protected TimeLogRepositoryInterface $timeLogRepo;

    public function __construct(TimeLogRepositoryInterface $timeLogRepo)
    {
        $this->timeLogRepo = $timeLogRepo;
    }

    public function startLog(array $data): TimeLog
    {
        $userId = Auth::id();

        // Prevent multiple active logs
        $activeLog = $this->timeLogRepo->getUserActiveLog($userId);
        if ($activeLog) {
            throw new \Exception('An active log already exists.');
        }

        return $this->timeLogRepo->create([
            'user_id'    => $userId,
            'project_id' => $data['project_id'],
            'start_time' => now(),
            'tag'        => $data['tag'] ?? null,
        ]);
    }

    public function endLog(int $logId): ?TimeLog
    {
        $log = $this->timeLogRepo->find($logId);

        // Validate ownership
        if (!$log || $log->user_id !== Auth::id()) {
            throw new \Exception('Log not found or access denied.');
        }

        if ($log->end_time) {
            throw new \Exception('Log is already ended.');
        }

        $log->end_time = now();
        $log->hours = $log->start_time
            ? round(Carbon::parse($log->start_time)->floatDiffInHours(now()), 2)
            : 0;

        return $this->timeLogRepo->update($logId, $log->toArray());
    }

    public function manualEntry(array $data): TimeLog
    {
        $data['user_id'] = Auth::id();

        // Auto-calculate hours if both start and end exist
        if (!empty($data['start_time']) && !empty($data['end_time'])) {
            $start = Carbon::parse($data['start_time']);
            $end = Carbon::parse($data['end_time']);
            $data['hours'] = round($start->floatDiffInHours($end), 2);
        }

        return $this->timeLogRepo->create($data);
    }

    public function updateLog(int $id, array $data): ?TimeLog
    {
        $log = $this->timeLogRepo->find($id);

        if (!$log || $log->user_id !== Auth::id()) {
            throw new \Exception('Not authorized');
        }

        // Recalculate hours if times updated
        if (!empty($data['start_time']) && !empty($data['end_time'])) {
            $start = Carbon::parse($data['start_time']);
            $end = Carbon::parse($data['end_time']);
            $data['hours'] = round($start->floatDiffInHours($end), 2);
        }

        return $this->timeLogRepo->update($id, $data);
    }

    public function deleteLog(int $id): bool
    {
        return $this->timeLogRepo->delete($id);
    }

    public function getUserLogs(int $userId): Collection
    {
        return $this->timeLogRepo->getLogsByUser($userId);
    }
}
