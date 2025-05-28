<?php

namespace App\Repositories\TimeLog;

use App\Models\TimeLog;
use Illuminate\Support\Collection;
use App\Repositories\TimeLog\TimeLogRepositoryInterface;

class TimeLogRepository implements TimeLogRepositoryInterface
{
    /**
     * It will start a Time Log.
     *
     * @return Collection
     */
    public function create(array $data): TimeLog
    {
        return TimeLog::create($data);
    }
    public function update(int $id, array $data): ?TimeLog
    {
        $log = TimeLog::find($id);
        if ($log) {
            $log->update($data);
            return $log;
        }
        return null;
    }
    public function delete(int $id): bool
    {
        $log = TimeLog::find($id);
        if ($log) {
            return $log->delete();
        }
        return false;
    }
    public function find(int $id): ?TimeLog
    {
        return TimeLog::find($id);
    }
    public function getUserActiveLog(int $userId): ?TimeLog
    {
        return TimeLog::where('user_id', $userId)
            ->whereNull('end_time')
            ->latest()
            ->first();
    }

    public function getLogsByUser(int $userId): Collection
    {
        return TimeLog::where('user_id', $userId)->latest()->get();
    }
}
