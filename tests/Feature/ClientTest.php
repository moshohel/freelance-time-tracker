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

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_client_creation(): void
    {
        $this->autheticaticateUser();
        $response = $this->post('/clients', $this->validPayload());
        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Test Client',
                'email' => 'featureTestUser@example.com',
                'contact_person' => 'John Doe',
            ]);
    }
    public function test_client_update(): void
    {
        $client = \App\Models\Client::factory()->create();
        $this->autheticaticateUser();

        $payload = [
            'name' => 'Updated Client',
            'email' => 'featureTestUser@example.com',
            'contact_person' => 'John Doe',
            'user_id' => $this->autheticaticateUser()->id,
        ];


        $response = $this->put("/clients/{$client->id}", $payload);
        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Client updated successfully',
                'client' => [
                    'id' => $client->id,
                    'name' => 'Updated Client',
                    'email' => 'featureTestUser@example.com',
                    'contact_person' => 'John Doe',
                    'user_id' => $this->autheticaticateUser()->id,
                ],
            ]);

        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'Updated Client',
            'email' => 'featureTestUser@example.com',
            'contact_person' => 'John Doe',
            'user_id' => $this->autheticaticateUser()->id,
        ]);
    }
    public function test_client_deletion(): void
    {
        $client = \App\Models\Client::factory()->create();
        $this->autheticaticateUser();

        $response = $this->delete("/clients/{$client->id}");
        $response->assertStatus(204);

        $this->assertDatabaseMissing('clients', [
            'id' => $client->id,
        ]);
    }
}
