<?php

namespace Database\Factories;

use App\Models\WebsocketApp;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WebsocketAppFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WebsocketApp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company,   // Random unique company name
            'app_key' => Str::random(32),                // Random 32 character string for app_key
            'app_secret' => Str::random(32),             // Random 32 character string for app_secret
            'ping_interval' => $this->faker->numberBetween(5, 60),  // Random ping interval between 5-60 seconds
            'allowed_origins' => [$this->faker->url],    // Random URL for allowed origins
            'max_message_size' => $this->faker->numberBetween(1024, 65536), // Random max message size in bytes
            'options' => [
                'debug' => $this->faker->boolean,         // Random boolean for debug option
                'compression' => $this->faker->boolean,   // Random boolean for compression
            ],
        ];
    }
}
