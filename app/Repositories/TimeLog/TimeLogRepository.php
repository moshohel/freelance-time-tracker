<?php

namespace App\Repositories\TimeLog;

use App\Models\TimeLog;
use Illuminate\Support\Collection;
use App\Repositories\TimeLog\TimeLogRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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

    public function getLogsByFilter(array $filters): Collection
    {
        $query = TimeLog::with(['project.client']); // eager load relationships

        if (!empty($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }
        if (!empty($filters['client_id'])) {
            $query->whereHas('project', function ($q) use ($filters) {
                $q->where('client_id', $filters['client_id']);
            });
        }
        if (!empty($filters['from'])) {
            $query->where('start_time', '>=', Carbon::parse($filters['from']));
        }
        if (!empty($filters['to'])) {
            // addDay ensures full-day inclusion
            $query->where('end_time', '<', Carbon::parse($filters['to'])->addDay());
        }
        if (!empty($filters['tag'])) {
            $query->where('tag', $filters['tag']);
        }

        return $query->latest()->get();
    }
}
