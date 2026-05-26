<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'code'        => 'C001',
                'name'        => 'C Programming',
                'category'    => 'ភាសាកម្មវិធី',
                'teacher'     => 'គ្រូ A',
                'description' => 'ភាសា C សម្រាប់ beginners',
                'image'       => null,
                'price'       => 0,
                'start_date'  => '2026-01-01',
                'end_date'    => '2026-06-30',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'code'        => 'C002',
                'name'        => 'Web Development',
                'category'    => 'Web',
                'teacher'     => 'គ្រូ B',
                'description' => 'HTML, CSS, JavaScript',
                'image'       => null,
                'price'       => 0,
                'start_date'  => '2026-01-01',
                'end_date'    => '2026-06-30',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'code'        => 'C003',
                'name'        => 'Laravel Framework',
                'category'    => 'Backend',
                'teacher'     => 'គ្រូ C',
                'description' => 'Laravel PHP Framework',
                'image'       => null,
                'price'       => 0,
                'start_date'  => '2026-01-01',
                'end_date'    => '2026-06-30',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        foreach ($courses as $course) {
            DB::table('courses')->insertOrIgnore($course);
        }

        $this->command->info('✅ CourseSeeder done!');
    }
}
