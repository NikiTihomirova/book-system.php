<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AuthorSeeder::class,
            GenreSeeder::class,
            BookSeeder::class,
            RolesTableSeeder::class,
            RoleSeeder::class,
            UserSeeder::class
        ]);
    }
}
