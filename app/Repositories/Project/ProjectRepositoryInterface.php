<?php

namespace App\Repositories\Project;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function getAllProjects(): Collection;

    public function getProjectById($id): ?Project;

    public function createProject(array $data): Project;

    public function updateProject($id, array $data): ?Project;

    public function deleteProject($id): bool;
}
