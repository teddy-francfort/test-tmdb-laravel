<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->createOne([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
    }
}
