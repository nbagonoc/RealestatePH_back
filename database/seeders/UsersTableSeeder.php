<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Agent',
            'email' => 'agent@gmail.com',
            'role' => 'agent',
            'password' => bcrypt('password1234!'),
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'role' => 'user',
            'password' => bcrypt('password1234!'),
        ]);
    }
}
