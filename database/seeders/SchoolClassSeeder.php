<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolClassSeeder extends Seeder
{
    public function run(): void
    {
                $classes = [
            ['code' => 'G1', 'name' => 'ថ្នាក់ទី១', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'G2', 'name' => 'ថ្នាក់ទី២', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'G3', 'name' => 'ថ្នាក់ទី៣', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'G4', 'name' => 'ថ្នាក់ទី៤', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'G5', 'name' => 'ថ្នាក់ទី៥', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'G6', 'name' => 'ថ្នាក់ទី៦', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'G7', 'name' => 'ថ្នាក់ទី៧', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'G8', 'name' => 'ថ្នាក់ទី៨', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'G9', 'name' => 'ថ្នាក់ទី៩', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'G10', 'name' => 'ថ្នាក់ទី១០', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'G11', 'name' => 'ថ្នាក់ទី១១', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'G12', 'name' => 'ថ្នាក់ទី១២', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('school_classes')->insert($classes);
    }
}