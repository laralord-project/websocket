<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminUserAccessTokenSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Enable logging for seeder tests
        Log::spy();
    }

    /** @test */
    public function it_skips_seeding_if_users_already_exist()
    {
        // Given: A user already exists
        User::factory()->create();

        // Then: The seeder should log a message and not create another user
        Log::shouldReceive('info')->with('Users already seeded. Skip seeder.')->once();
        // When: We run the seeder
        $this->artisan('db:seed', ['--class' => 'Database\\Seeders\\AdminUserAccessToken']);

        // Log::shouldHaveReceived('info')->with('Users already seeded. Skip seeder.')->once();
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function it_skips_seeding_if_admin_user_token_is_not_set()
    {
        // Given: No users and no ADMIN_USER_TOKEN set in environment
        $this->assertNull(env('ADMIN_USER_TOKEN'));

        // When: We run the seeder
        $this->artisan('db:seed', ['--class' => 'Database\\Seeders\\AdminUserAccessToken']);

        // Then: The seeder should log a message and not create a user
        Log::shouldHaveReceived('info')->with('Init token is not specified. Skip seeder.')->once();
        $this->assertCount(0, User::all());
    }

    /** @test */
    public function it_creates_an_admin_user_and_access_token_if_no_users_exist_and_token_is_set()
    {
        // Given: No users exist, and we set the ADMIN_USER_TOKEN in the environment
        $tokenValue = 'test-token';
        config(['app.key' => Str::random(32)]); // Ensure app key exists
        putenv('ADMIN_USER_TOKEN=' . $tokenValue);
        $this->assertEquals($tokenValue, env('ADMIN_USER_TOKEN'));
        // When: We run the seeder
        $this->artisan('db:seed', ['--class' => 'Database\\Seeders\\AdminUserAccessToken']);

        // Then: The user and token should be created
        $this->assertCount(1, User::all());
        $user = User::first();
        $this->assertEquals('admin', $user->name);

        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'access-token',
            'token' => hash('sha256', $tokenValue),
        ]);

        Log::shouldHaveReceived('info')->with('User Admin created with default access token')->once();
    }
}
