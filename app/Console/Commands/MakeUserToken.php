<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:create {user=admin: username for Token generation} {--token-name=api-access} {--create} {--revoke-old} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('user');
        $user = User::whereName('name', $username)->first();
        $created = false;

        if (!$user) {
            if ($this->options()['create'] ?? false) {
                $user = User::create(['name' => $username, 'password' => \Str::random(32)]);
                $created = true;
            }
        }

        if (!$user) {
            $this->error(\json_encode(['error' => 1, 'message' => "User {$username} not found"]));

            return 1;
        }

        $token = $user->createToken($this->option('token-name'));

        $response = [
            'status' => 'success',
            'message' => 'Token has been created',
            'user_id' => $user->id,
            'user_name' => $user->name,
            'token' => $token->plainTextToken,
        ];

        $this->line(\json_encode($response));

        return 0;
    }
}
