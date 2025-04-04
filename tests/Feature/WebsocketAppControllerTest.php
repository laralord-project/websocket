<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WebsocketApp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class WebsocketAppControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user for authenticated requests
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_can_list_websocket_apps()
    {
        // Given: A few WebsocketApp entries exist in the database
        WebsocketApp::factory()->count(5)->create();

        // When: We make a GET request to list all apps
        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/applications');

        // Then: We should see a paginated response with WebsocketApps
        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);
        $this->assertCount(5, $response->json('data'));
    }

    /** @test */
    public function it_validates_when_creating_a_websocket_app()
    {
        // Given: Invalid data (name is too short and missing)
        $invalidData = [
            'name' => 'a',  // too short
        ];

        // When: We attempt to create a new WebsocketApp with invalid data
        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/applications', $invalidData);

        // Then: The response should contain validation errors
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_can_create_a_websocket_app_with_valid_data()
    {
        // Given: Valid data for creating a WebsocketApp
        $data = [
            'name' => 'New Websocket App',
            'ping_interval' => 15,
            'max_message_size' => 2048,
            'allowed_origins' => ['https://example.com'],
        ];

        // When: We send a POST request to create a WebsocketApp
        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/applications', $data);

        // Then: The WebsocketApp should be created in the database
        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'New Websocket App']);
        $this->assertDatabaseHas('websocket_apps', ['name' => 'New Websocket App']);
    }

    /** @test */
    public function it_checks_uniqueness_of_name_when_creating_a_websocket_app()
    {
        // Given: A WebsocketApp already exists with the same name
        $existingApp = WebsocketApp::factory()->create(['name' => 'Existing App']);

        // When: We attempt to create a new WebsocketApp with the same name
        $data = ['name' => 'Existing App'];

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/applications', $data);

        // Then: The response should contain validation errors for uniqueness
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_can_show_a_websocket_app()
    {
        // Given: A WebsocketApp exists in the database
        $websocketApp = WebsocketApp::factory()->create();

        // When: We send a GET request to fetch a single WebsocketApp
        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson("/api/applications/{$websocketApp->id}");

        // Then: We should see the WebsocketApp details
        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $websocketApp->id, 'name' => $websocketApp->name]);
    }

    /** @test */
    public function it_can_update_a_websocket_app_with_valid_data()
    {
        // Given: A WebsocketApp exists in the database
        $websocketApp = WebsocketApp::factory()->create();

        // When: We send a PUT request to update the WebsocketApp
        $updatedData = [
            'name' => 'Updated Websocket App',
            'app_key' => Str::random(32),
            'app_secret' => Str::random(32),
            'ping_interval' => 20,
            'max_message_size' => 4096,
            'allowed_origins' => ['https://updated-origin.com'],
        ];

        $response = $this->actingAs($this->user, 'sanctum')
            ->putJson("/api/applications/{$websocketApp->id}", $updatedData);

        // Then: The WebsocketApp should be updated in the database
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Websocket App']);
        $this->assertDatabaseHas('websocket_apps', ['id' => $websocketApp->id, 'name' => 'Updated Websocket App']);
    }

    /** @test */
    public function it_checks_update_validation_for_websocket_app()
    {
        // Given: A WebsocketApp exists in the database
        $websocketApp = WebsocketApp::factory()->create();

        // When: We send an invalid PUT request to update the WebsocketApp
        $invalidData = [
            'name' => 'a',  // too short
            'app_key' => 'short-key', // too short
            'app_secret' => 'short-secret', // too short
            'ping_interval' => 'invalid', // not numeric
        ];

        $response = $this->actingAs($this->user, 'sanctum')
            ->putJson("/api/applications/{$websocketApp->id}", $invalidData);

        // Then: The response should contain validation errors
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'app_key', 'app_secret', 'ping_interval']);
    }

    /** @test */
    public function it_can_delete_a_websocket_app()
    {
        // Given: A WebsocketApp exists in the database
        $websocketApp = WebsocketApp::factory()->create();

        // When: We send a DELETE request to remove the WebsocketApp
        $response = $this->actingAs($this->user, 'sanctum')
            ->deleteJson("/api/applications/{$websocketApp->id}");

        // Then: The WebsocketApp should be deleted from the database
        $response->assertStatus(200);
        $this->assertDatabaseMissing('websocket_apps', ['id' => $websocketApp->id]);
    }
}
