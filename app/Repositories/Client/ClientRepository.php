<?php

namespace App\Repositories\Client;

use App\Models\Client;
use App\Repositories\Client\ClientRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ClientRepository implements ClientRepositoryInterface
{
    public function index(): Collection
    {
        return Client::with('projects')->get();
    }
    public function store(array $data): Client
    {
        return Client::create($data);
    }
    public function show(int $id): ?Client
    {
        return Client::with('projects')->find($id);
    }
    public function update(int $id, array $data): ?Client
    {
        $client = Client::find($id);
        if ($client) {
            $client->update($data);
            return $client;
        }
        return null;
    }
    public function destroy(int $id): bool
    {
        $client = Client::find($id);
        if ($client) {
            return $client->delete();
        }
        return false;
    }
}
