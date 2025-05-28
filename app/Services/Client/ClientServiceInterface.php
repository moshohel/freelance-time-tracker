<?php

namespace App\Services\Client;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

interface ClientServiceInterface
{
    public function index(): Collection;
    public function store(array $data): Client;
    public function show(int $id): ?Client;
    public function update(int $id, array $data): ?Client;
    public function destroy(int $id): bool;
}
