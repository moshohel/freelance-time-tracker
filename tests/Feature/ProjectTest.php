<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->client = Client::factory()->create();
    }

    public function test_project_can_be_created(): void
    {
        $payload = [
            'title' => 'Test Project',
            'description' => 'This is a test project.',
            'client_id' => $this->client->id,
            'status' => 'active',
            'deadline' => now()->addDays(30)->toDateString(),
        ];

        $response = $this->postJson('/api/projects', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Test Project']);

        $this->assertDatabaseHas('projects', ['title' => 'Test Project']);
    }

    public function test_project_can_be_updated(): void
    {
        $project = Project::factory()->create(['client_id' => $this->client->id]);

        $updated = [
            'title' => 'Updated Project',
            'description' => 'Updated description.',
            'client_id' => $this->client->id,
            'status' => 'active',
            'deadline' => now()->addDays(15)->toDateString(),
        ];

        $response = $this->putJson("/api/projects/{$project->id}", $updated);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Project']);

        $this->assertDatabaseHas('projects', ['id' => $project->id, 'title' => 'Updated Project']);
    }

    public function test_project_can_be_deleted(): void
    {
        $project = Project::factory()->create(['client_id' => $this->client->id]);

        $response = $this->delete("/api/projects/{$project->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
