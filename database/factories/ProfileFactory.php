<?php

namespace Database\Factories;

use App\Models\Language;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'first_name' => $this->faker->firstName(),
          'last_name'=> $this->faker->lastName(),
          'language_id' => Language::where('lang_iso', 'eng')->first()?->id,
          'ui_scheme' => 'light',
        ];
    }
}
