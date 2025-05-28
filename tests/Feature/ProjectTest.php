<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;


    protected function autheticaticateUser(): \App\Models\User
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        return $user;
    }
    protected function validPayload(): array
    {
        return [
            'name' => 'Test Project',
            'description' => 'This is a test project.',
            'client_id' => $this->autheticaticateUser()->id,
            'status' => 'active',
            'deadline' => now()->addDays(30)->toDateString(),
        ];
    }

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_project_creation(): void
    {
        $this->autheticaticateUser();
        $response = $this->post('/projects', $this->validPayload());
        $response->assertStatus(201)
            ->assertJsonFragment([
                'message' => 'Project created successfully.',
                'project' => [
                    'name' => 'Test Project',
                    'description' => 'This is a test project.',
                ],
                'client_id' => $this->autheticaticateUser()->id,
                'status' => 'active',
                'deadline' => now()->addDays(30)->toDateString(),
            ]);

        $this->assertDatabaseHas('projects', [
            'name' => 'Test Project',
            'description' => 'This is a test project.',
            'client_id' => $this->autheticaticateUser()->id,
            'status' => 'active',
            'deadline' => now()->addDays(30)->toDateString(),
        ]);
    }
    public function test_project_update(): void
    {
        $project = \App\Models\Project::factory()->create();
        $this->autheticaticateUser();

        $payload = [
            'name' => 'Updated Project',
            'description' => 'This is an updated project.',
            'client_id' => $this->autheticaticateUser()->id,
            'status' => 'active',
            'deadline' => now()->addDays(30)->toDateString(),
        ];

        $response = $this->put("/projects/{$project->id}", $payload);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Project updated successfully.',
                'project' => [
                    'id' => $project->id,
                    'name' => 'Updated Project',
                    'description' => 'This is an updated project.',
                    'client_id' => $this->autheticaticateUser()->id,
                    'status' => 'active',
                    'deadline' => now()->addDays(30)->toDateString(),
                ],
            ]);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Updated Project',
            'description' => 'This is an updated project.',
            'client_id' => $this->autheticaticateUser()->id,
            'status' => 'active',
            'deadline' => now()->addDays(30)->toDateString(),
        ]);
    }
    public function test_project_deletion(): void
    {
        $project = \App\Models\Project::factory()->create();
        $this->autheticaticateUser();

        $response = $this->delete("/projects/{$project->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('projects', [
            'message' => 'Brand deleted successfully',
            'id' => $project->id,
        ]);
    }
}
