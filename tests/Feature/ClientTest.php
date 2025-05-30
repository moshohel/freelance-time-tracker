<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    protected function autheticaticateUser(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    protected function validPayload(): array
    {
        return [
            'name' => 'Test Client',
            'email' => 'featureTestUser@example.com',
            'contact_person' => 'John Doe',
            'user_id' => $this->autheticaticateUser()->id,
        ];
    }

    public function test_client_creation(): void
    {
        $this->autheticaticateUser();
        $response = $this->post('/api/clients', $this->validPayload());
        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Test Client',
                'email' => 'featureTestUser@example.com',
                'contact_person' => 'John Doe',
            ]);
    }
    public function test_client_update(): void
    {
        $user = $this->autheticaticateUser();

        $client = \App\Models\Client::factory()->create([
            'user_id' => $user->id,
        ]);

        $payload = [
            'name' => 'Updated Client',
            'email' => 'featureTestUser@example.com',
            'contact_person' => 'John Doe',
            'user_id' => $user->id,
        ];

        $response = $this->put("/api/clients/{$client->id}", $payload);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Updated Client',
                'email' => 'featureTestUser@example.com',
                'contact_person' => 'John Doe',
                'user_id' => $user->id,
            ]);

        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'Updated Client',
            'user_id' => $user->id,
        ]);
    }

    public function test_client_deletion(): void
    {
        $client = \App\Models\Client::factory()->create();
        $this->autheticaticateUser();

        $response = $this->delete("/api/clients/{$client->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('clients', [
            'id' => $client->id,
        ]);
    }
}
