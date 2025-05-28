<?php

namespace App\Services\Client;

use App\Models\Client;
use App\Services\Client\ClientServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Client\ClientRepositoryInterface;

class ClientService implements ClientServiceInterface
{
    protected ClientRepositoryInterface $clientRepository;
    public function __construct()
    {
        $this->clientRepository = app(ClientRepositoryInterface::class);
    }
    public function index(): Collection
    {
        return $this->clientRepository->index();
    }
    public function store(array $data): Client
    {
        return $this->clientRepository->store($data);
    }
    public function show(int $id): ?Client
    {
        return $this->clientRepository->show($id);
    }
    public function update(int $id, array $data): ?Client
    {
        return $this->clientRepository->update($id, $data);
    }
    public function destroy(int $id): bool
    {
        return $this->clientRepository->destroy($id);
    }
}
