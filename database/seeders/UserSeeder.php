<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'director1',
            'email' => 'director1@gmail.com',
            'role' => 'director',
            'password' => '12345678'
        ]);
        User::create([
            'username' => 'manager1',
            'email' => 'manager1@gmail.com',
            'role' => 'manager',
            'password' => '12345678'
        ]);
        User::create([
            'username' => 'employee1',
            'email' => 'employee1@gmail.com',
            'role' => 'employee',
            'password' => '12345678'
        ]);
    }
}
