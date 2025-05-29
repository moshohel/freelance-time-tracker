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

        if (!$log) {
            throw new \Exception('Time log not found.');
        }

        if ($log->user_id !== Auth::id()) {
            throw new \Exception('You are not allowed to end this time log.');
        }

        if ($log->end_time !== null) {
            throw new \Exception('This time log has already been ended.');
        }

        $log->end_time = now();

        if ($log->start_time) {
            $start = Carbon::parse($log->start_time);
            $end = Carbon::now();
            $log->hours = round($start->floatDiffInHours($end), 2);
        } else {
            $log->hours = 0;
        }

        return $this->timeLogRepo->update($logId, $log->toArray());
    }

    public function manualEntry(array $data): TimeLog
    {
        $data['user_id'] = Auth::id();

        if (!empty($data['start_time']) && !empty($data['end_time'])) {
            $start = Carbon::parse($data['start_time']);
            $end = Carbon::parse($data['end_time']);
            $data['hours'] = round($start->floatDiffInHours($end), 2);
        } else {
            $data['hours'] = $data['hours'] ?? 0;
        }

        return $this->timeLogRepo->create($data);
    }

    public function updateLog(int $id, array $data): ?TimeLog
    {
        $log = $this->timeLogRepo->find($id);

        if (!$log) {
            throw new \Exception('Time log not found.');
        }

        if ($log->user_id !== Auth::id()) {
            throw new \Exception('You cannot update this time log.');
        }

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
    public function getLogsByFilter(array $filters): Collection
    {
        return $this->timeLogRepo->getLogsByFilter($filters);
    }
}
