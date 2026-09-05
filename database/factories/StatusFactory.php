<?php

namespace Database\Factories;

use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => fake()->randomNumber(),
            'status_id' => fake()->randomNumber(),
            'content' => fake()->text(),
            'spoiler_text' => '',
            'url' => fake()->unique()->url,
            'uri' => fake()->unique()->uuid,
        ];
    }
}
