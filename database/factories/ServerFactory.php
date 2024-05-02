<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Server>
 */
class ServerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'app_id' => fake()->randomNumber(),
            'domain' => 'https://'.fake()->domainName(),
            'redirect_uri' => fake()->url(),
            'client_id' => Str::random(20),
            'client_secret' => Str::random(20),
        ];
    }
}
