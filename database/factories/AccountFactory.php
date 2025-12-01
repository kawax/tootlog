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
        $user_name = fake()->userName;
        $domain = fake()->unique()->domainName;

        $image = 'https://placehold.co/640x480';

        return [
            'user_id' => fake()->randomNumber(),
            'server_id' => fake()->randomNumber(),
            'account_id' => fake()->randomNumber(),
            'since_id' => fake()->randomNumber(),
            'token' => Str::random(20),
            'username' => $user_name,
            'acct' => $user_name,
            'display_name' => fake()->name,
            'locked' => false,
            'account_created_at' => fake()->dateTime,
            'statuses_count' => fake()->randomNumber(),
            'following_count' => fake()->randomNumber(),
            'followers_count' => fake()->randomNumber(),
            'note' => fake()->text(),
            'url' => 'https://'.$domain.'/@'.$user_name,
            'avatar' => $image,
            'avatar_static' => $image,
            'header' => $image,
            'header_static' => $image,
        ];
    }
}
