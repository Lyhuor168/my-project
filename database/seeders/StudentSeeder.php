<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'student@university.edu'],
            [
                'name'     => 'លី មករា',
                'password' => Hash::make('student1234'),
                'role'     => 'student',
            ]
        );

        $students = [
            ['name'=>'លី មករា','email'=>'student@university.edu','phone'=>'012345678','gender'=>'male','date_of_birth'=>'2003-05-10','address'=>'ភ្នំពេញ','score'=>85.5],
            ['name'=>'សុខ សុភា','email'=>'soksopha@student.edu','phone'=>'012345679','gender'=>'female','date_of_birth'=>'2003-08-15','address'=>'សៀមរាប','score'=>78.0],
            ['name'=>'ចាន់ ដារា','email'=>'chandara@student.edu','phone'=>'012345680','gender'=>'male','date_of_birth'=>'2002-12-20','address'=>'កណ្តាល','score'=>90.0],
        ];

        foreach ($students as $data) {
            Student::query()->firstOrCreate(['email' => $data['email']], $data);
        }
    }
}
