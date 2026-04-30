<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Course;
class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'name'        => 'C',
                'code'        => 'C001',
                'category'    => 'ភាសាកម្មវិធី',
                'teacher'     => 'គ្រូ A',
                'description' => 'កម្មវិធី C គឺជាភាសាសរសេរកម្មវិធី (programming language) ដែលមានភាពទូលំទូលាយ និងត្រូវបានគេប្រើប្រាស់ជាច្រើនឆ្នាំ។',
                'image'       => 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjGQSXPCMJJqVFjFBbvJCBWoaqLhEh_OiblD7bCVxEsMJBLCPr4xfUZylJMRhO7IfI1E8T7xtpTiUH0l7h3yEYV0KbKQvCTW3G4X6e2fTcUF31MXL2cpJZZDKVnvAe_E0-kJQ0Nrv3tZnBrXY1q8tF2y7Z2hU/w1200/c-programming.jpg',
                'price'       => 0,
            ],
            [
                'name'        => 'Python',
                'code'        => 'PY001',
                'category'    => 'ភាសាកម្មវិធី',
                'teacher'     => 'គ្រូ B',
                'description' => 'កម្មវិធី Python គឺជាភាសាកម្មវិធីកម្រិតខ្ពស់ (high-level programming language) ដែលមានវាក្យស័ព្ទសាមញ្ញ អានយល់បានងាយ។',
                'image'       => 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEh6bb2hsFXj4i-ea7H5iHEf4OVlAWtkeqpqS44iAtkCl05RFI4RLuttvbgqIW8IfG3rbKdDjQKskz1KqDBoW7e3qMtltWnpqb2xER3HqshwLi-dvQAWW0QZUJm_GV_fC1VAGXiIaZIdMwSegedY76sH3V5F_W1JBnB7gPKTywWZt-XK-evgMeLpd1WyRXc-/w1200/python.jpg',
                'price'       => 0,
            ],
            [
                'name'        => 'Git',
                'code'        => 'GIT001',
                'category'    => 'ឧបករណ៍',
                'teacher'     => 'គ្រូ C',
                'description' => 'កម្មវិធី Git គឺជាកម្មវិធី Version Control System (VCS) ដែលត្រូវបានគេប្រើដើម្បីតាមដាន source code។',
                'image'       => 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjsIBMqfgpJPHBECi7kOWoMFm8hLgGMkBJ0lOKLf0F-Bq4gBD0uOGNY0wqDmQ1uBQcE4eNQ2jOPqKJGTzWKKlrxFMmIpMkpZPLRNXr3dBISmJMUBDVAu1XTR0c_1FZ-Bfn8N3FNRdnRYRZ-H49pPe4tAx0qZ/w1200/git.jpg',
                'price'       => 0,
            ],
        ];
        foreach ($courses as $course) {
            Course::updateOrCreate(['code' => $course['code']], $course);
        }
    }
}
