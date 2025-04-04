<?php

namespace Tests\Feature;

use App\Components\WebsocketApplicationProvider;
use App\Models\WebsocketApp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Laravel\Reverb\Application;
use Tests\TestCase;

class WebsocketApplicationProviderTest extends TestCase
{
    use RefreshDatabase;

    protected WebsocketApplicationProvider $provider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->provider = new WebsocketApplicationProvider();
    }

    /** @test */
    public function it_can_return_all_applications()
    {
        // Arrange: Create multiple websocket applications
        WebsocketApp::factory()->count(5)->create();

        // Act: Call the all() method
        $applications = $this->provider->all();

        // Assert: Check if all applications are returned correctly
        $this->assertCount(5, $applications);
        foreach ($applications as $application) {
            $this->assertInstanceOf(Application::class, $application);
        }
    }

    /** @test */
    public function it_can_find_application_by_id()
    {
        // Arrange: Create a websocket application
        $websocketApp = WebsocketApp::factory()->create();

        // Act: Call the findById() method
        $application = $this->provider->findById($websocketApp->id);

        // Assert: Check if the correct application is returned
        $this->assertInstanceOf(Application::class, $application);
        $this->assertEquals($websocketApp->id, $application->id());
        $this->assertEquals($websocketApp->app_secret, $application->secret());
    }

    /** @test */
    public function it_can_find_application_by_key()
    {
        // Arrange: Create a websocket application
        $websocketApp = WebsocketApp::factory()->create();

        // Act: Call the findByKey() method
        $application = $this->provider->findByKey($websocketApp->app_key);

        // Assert: Check if the correct application is returned
        $this->assertInstanceOf(Application::class, $application);
        $this->assertEquals($websocketApp->app_key, $application->key());
        $this->assertEquals($websocketApp->app_secret, $application->secret());
    }

    /** @test */
    public function it_throws_exception_if_application_not_found_by_key()
    {
        // Act & Assert: Call findByKey with a non-existing key and expect an exception
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        $this->provider->findByKey('non-existing-key');
    }
}
