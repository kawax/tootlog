<?php

namespace Database\Seeders;

use App\Models\Server;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
        ]);

        Server::factory()->create([
            'domain' => 'https://example.com',
            'redirect_uri' => route('accounts.callback'),
        ]);
    }
}
