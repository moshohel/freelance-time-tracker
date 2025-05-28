<?php

namespace App\Services\TimeLog;

use App\Models\TimeLog;
use Illuminate\Support\Collection;

interface TimeLogServiceInterface
{
    public function startLog(array $data): TimeLog;
    public function endLog(int $logId): ?TimeLog;
    public function manualEntry(array $data): TimeLog;
    public function updateLog(int $id, array $data): ?TimeLog;
    public function deleteLog(int $id): bool;
    public function getUserLogs(int $userId): Collection;
    public function getFilteredLogs(array $filters): Collection;
}
