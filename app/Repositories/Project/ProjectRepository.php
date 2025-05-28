<?php

namespace App\Repositories\Project;

use App\Repositories\Project\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllProjects(): Collection
    {
        return Project::with('client')->get();
    }

    public function getProjectById($id): ?Project
    {
        return Project::with('client')->find($id);
    }

    public function createProject(array $data): Project
    {
        return Project::create($data);
    }

    public function updateProject($id, array $data): ?Project
    {
        $project = Project::find($id);
        if ($project) {
            $project->update($data);
            return $project;
        }
        return null;
    }

    public function deleteProject($id): bool
    {
        $project = Project::find($id);
        if ($project) {
            return $project->delete();
        }
        return false;
    }
}
