<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_clients(): void
    {
        Client::factory()->create(['name' => 'Test Client']);

        $response = $this->getJson('/api/clients');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'name', 'email', 'status']
                     ]
                 ]);
    }

    public function test_can_create_client(): void
    {
        $clientData = [
            'name' => 'New Client',
            'email' => 'newclient@example.com',
            'phone' => '+1-555-1234',
            'status' => 'active',
        ];

        $response = $this->postJson('/api/clients', $clientData);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'New Client',
                     'email' => 'newclient@example.com',
                 ]);

        $this->assertDatabaseHas('clients', ['name' => 'New Client']);
    }

    public function test_can_show_client(): void
    {
        $client = Client::factory()->create(['name' => 'Test Client']);

        $response = $this->getJson("/api/clients/{$client->id}");

        $response->assertStatus(200)
                 ->assertJson(['name' => 'Test Client']);
    }

    public function test_can_update_client(): void
    {
        $client = Client::factory()->create(['name' => 'Old Name']);

        $response = $this->putJson("/api/clients/{$client->id}", [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['name' => 'Updated Name']);

        $this->assertDatabaseHas('clients', ['id' => $client->id, 'name' => 'Updated Name']);
    }

    public function test_can_delete_client(): void
    {
        $client = Client::factory()->create();

        $response = $this->deleteJson("/api/clients/{$client->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}
