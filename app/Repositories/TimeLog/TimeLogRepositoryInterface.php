<?php

namespace App\Repositories\TimeLog;

use App\Models\TimeLog;
use Illuminate\Support\Collection;

interface TimeLogRepositoryInterface
{
    public function create(array $data): TimeLog;
    public function update(int $id, array $data): ?TimeLog;
    public function delete(int $id): bool;
    public function find(int $id): ?TimeLog;
    public function getUserActiveLog(int $userId): ?TimeLog;
    public function getLogsByUser(int $userId): Collection;
}
