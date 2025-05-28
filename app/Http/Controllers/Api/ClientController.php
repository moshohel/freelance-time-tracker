<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Client\ClientServiceInterface;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ClientResource;


class ClientController extends Controller
{
    protected ClientServiceInterface $clientService;
    public function __construct(ClientServiceInterface $clientService)
    {
        $this->clientService = $clientService;
    }
    public function index(): JsonResponse
    {
        $clients = $this->clientService->index();
        return response()->json(ClientResource::collection($clients), 200);
    }
    public function store(StoreClientRequest $request): JsonResponse
    {
        Log::info('Auth user:', ['user' => Auth::user()]);
        try {
            $client = $this->clientService->store($request->validated());
            return response()->json($client, 201);
        } catch (\Exception $e) {
            Log::error('Error storing client: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to create client', 'error' => $e,], 400);
        }
    }
    public function show(int $id): JsonResponse
    {
        $client = $this->clientService->show($id);
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 204);
        }
        return response()->json(new ClientResource($client), 200);
    }
    public function update(UpdateClientRequest $request, int $id): JsonResponse
    {
        try {
            $client = $this->clientService->update($id, $request->validated());
            if (!$client) {
                return response()->json(['error' => 'Client not found'], 204);
            }
            return response()->json($client, 200);
        } catch (\Exception $e) {
            Log::error('Error updating client: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update client'], 500);
        }
    }
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->clientService->destroy($id);
            if (!$deleted) {
                return response()->json(['error' => 'Client not found'], 204);
            }
            return response()->json(['message' => 'Client deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting client: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete client'], 500);
        }
    }
}
