<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomNumber(),
            'server_id' => fake()->randomNumber(),
            'account_id' => fake()->randomNumber(),
            'since_id' => fake()->randomNumber(),
            'token' => Str::random(20),
            'username' => fake()->userName,
            'acct' => fake()->userName,
            'display_name' => fake()->name,
            'locked' => false,
            'account_created_at' => fake()->dateTime,
            'statuses_count' => fake()->randomNumber(),
            'following_count' => fake()->randomNumber(),
            'followers_count' => fake()->randomNumber(),
            'note' => fake()->text(),
            'url' => 'https://'.fake()->unique()->domainName.'/test',
            'avatar' => fake()->imageUrl(),
            'avatar_static' => fake()->imageUrl(),
            'header' => fake()->imageUrl(),
            'header_static' => fake()->imageUrl(),
        ];
    }
}
