<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Str;

class AdminUserAccessToken extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::exists()) {
            Log::info('Users already seeded. Skip seeder.');

            return;
        }

        if (!$token = env('ADMIN_USER_TOKEN')) {
            Log::info('Init token is not specified. Skip seeder.');

            return;
        }

        $user = User::create([
            'name' => 'admin',
            'password' => Str::random(30),
        ]);

        $user->tokens()
            ->create([
                'name' => 'access-token',
                'token' => hash('sha256', $token),
                'abilities' => ['*'],
                'expires_at' => null,
            ]);

        Log::info('User Admin created with default access token');
    }
}
