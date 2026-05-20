<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@culinarilicious.com',
            'role' => 'admin',
            'password' => bcrypt('password')
        ]);

        User::factory()->create([
            'name' => 'Rider User',
            'email' => 'rider@culinarilicious.com',
            'role' => 'rider',
            'password' => bcrypt('password')
        ]);

        User::factory()->create([
            'name' => 'Buyer User',
            'email' => 'buyer@culinarilicious.com',
            'role' => 'buyer',
            'password' => bcrypt('password')
        ]);
    }
}