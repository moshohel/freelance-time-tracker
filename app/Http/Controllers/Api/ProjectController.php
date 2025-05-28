<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Services\Project\ProjectServiceInterface;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    protected ProjectServiceInterface $projectService;
    public function __construct(ProjectServiceInterface $projectService)
    {
        $this->projectService = $projectService;
    }
    public function index(): JsonResponse
    {
        try {
            $projects = $this->projectService->getAllProjects();
            return response()->json(ProjectResource::collection($projects), 200);
        } catch (\Exception $e) {
            Log::error('Error fetching projects: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch projects', 'error' => $e], 404);
        }
    }
    public function show($id): JsonResponse
    {
        try {
            $project = $this->projectService->getProjectById($id);
            if (!$project) {
                return response()->json(['error' => 'Project not found'], 404);
            }
            return response()->json(new ProjectResource($project), 200);
        } catch (\Exception $e) {
            Log::error('Error fetching project: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch project', 'error' => $e], 500);
        }
    }
    public function store(StoreProjectRequest $request): JsonResponse
    {
        try {
            $project = $this->projectService->createProject($request->validated());
            return response()->json($project, 201);
        } catch (\Exception $e) {
            Log::error('Error creating project: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create project', 'error' => $e], 500);
        }
    }
    public function update(UpdateProjectRequest $request, $id): JsonResponse
    {
        try {
            $project = $this->projectService->updateProject($id, $request->validated());
            if (!$project) {
                return response()->json(['error' => 'Project not found'], 404);
            }
            return response()->json($project, 200);
        } catch (\Exception $e) {
            Log::error('Error updating project: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update project', 'error' => $e], 500);
        }
    }
    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->projectService->deleteProject($id);
            if (!$deleted) {
                return response()->json(['error' => 'Project not found'], 404);
            }
            return response()->json(['message' => 'Project deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting project: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete project', 'error' => $e], 500);
        }
    }
}
