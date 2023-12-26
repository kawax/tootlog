<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->unique()->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'email_verified_at' => $faker->dateTime,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Server::class, function (Faker $faker) {
    return [
        'app_id' => $faker->randomNumber(),
        'domain' => 'https://'.$faker->unique()->domainName,
        'redirect_uri' => $faker->unique()->url,
        'client_id' => Str::random(20),
        'client_secret' => Str::random(20),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Account::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'server_id' => $faker->randomNumber(),
        'account_id' => $faker->randomNumber(),
        'since_id' => $faker->randomNumber(),
        'token' => Str::random(20),
        'username' => $faker->userName,
        'acct' => $faker->userName,
        'display_name' => $faker->name,
        'locked' => false,
        'account_created_at' => $faker->dateTime,
        'statuses_count' => $faker->randomNumber(),
        'following_count' => $faker->randomNumber(),
        'followers_count' => $faker->randomNumber(),
        'note' => $faker->text(),
        'url' => 'https://'.$faker->unique()->domainName,
        'avatar' => $faker->imageUrl(),
        'avatar_static' => $faker->imageUrl(),
        'header' => $faker->imageUrl(),
        'header_static' => $faker->imageUrl(),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Status::class, function (Faker $faker) {
    return [
        'account_id' => $faker->randomNumber(),
        'status_id' => $faker->randomNumber(),
        'content' => $faker->text(),
        'spoiler_text' => '',
        'url' => $faker->unique()->url,
        'uri' => $faker->unique()->uuid,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
