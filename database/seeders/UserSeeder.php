<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Създаване на администратор
        User::create([
            'name' => 'Admin',
            'email' => 'admin@php.com',
            'password' => Hash::make('Admin1!'), // Задай силна парола
            'role' => 'admin',
        ]);

        // Създаване на обикновен потребител
        User::create([
            'name' => 'User',
            'email' => 'user@php.com',
            'password' => Hash::make('User1!'),
            'role' => 'user',
        ]);
    }
}
