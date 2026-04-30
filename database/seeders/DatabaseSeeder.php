<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'lyhourheoun04@gmail.com'],
            [
                'name' => 'Lyhuo',
                'password' => bcrypt('password'),
            ]
        );

        $this->call([
            TeacherSeeder::class,
            StudentSeeder::class,
            SchoolClassSeeder::class,
            CourseSeeder::class,
            ShopSeeder::class,
            ProductSeeder::class,
            BookSeeder::class,
        ]);
    }
}