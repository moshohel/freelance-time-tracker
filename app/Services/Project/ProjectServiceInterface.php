<?php

namespace App\Services\Project;


use Illuminate\Database\Eloquent\Collection;
use App\Models\Project;
use App\Repositories\Project\ProjectRepositoryInterface;

interface ProjectServiceInterface
{
    public function getAllProjects(): Collection;

    public function getProjectById($id): ?Project;

    public function createProject(array $data): Project;

    public function updateProject($id, array $data): ?Project;

    public function deleteProject($id): bool;
}
