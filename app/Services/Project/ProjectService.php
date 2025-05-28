<?php

namespace App\Services\Project;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Project\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Log;
use App\Services\Project\ProjectServiceInterface;

class ProjectService implements ProjectServiceInterface
{
    protected ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }
    public function getAllProjects(): Collection
    {
        return $this->projectRepository->getAllProjects();
    }
    public function getProjectById($id): ?Project
    {
        return $this->projectRepository->getProjectById($id);
    }
    public function createProject(array $data): Project
    {
        return $this->projectRepository->createProject($data);
    }
    public function updateProject($id, array $data): ?Project
    {
        return $this->projectRepository->updateProject($id, $data);
    }
    public function deleteProject($id): bool
    {
        return $this->projectRepository->deleteProject($id);
    }
}
