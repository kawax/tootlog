<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Server;
use App\Models\Status;
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

        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'test',
                'password' => 'password',
                'email_verified_at' => now(),
            ],
        );

        $server = Server::factory()->create([
            'domain' => 'https://example.com',
            'redirect_uri' => route('accounts.callback'),
        ]);

        Status::factory(10)
            ->for(Account::factory()
                ->for($user)
                ->for($server)
                ->create())
            ->create();
    }
}
