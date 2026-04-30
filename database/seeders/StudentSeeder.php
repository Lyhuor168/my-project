<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['name' => 'ហេង ចរិយា', 'name_en' => 'Heng Chariya', 'email' => 'hengchariya91@student.com'],
            ['name' => 'កុសល សុវត្ថិ', 'name_en' => 'Kosal Sovath', 'email' => 'kosalsovath74@student.com'],
            ['name' => 'ធារ៉ា សិរី', 'name_en' => 'Theara Serei', 'email' => 'thearaserei32@student.com'],
            ['name' => 'វឌ្ឍនៈ ពិសិដ្ឋ', 'name_en' => 'Vattanac Piseth', 'email' => 'vattanacpiseth68@student.com'],
            ['name' => 'រិទ្ធី សំណាង', 'name_en' => 'Rithy Samnang', 'email' => 'rithysamnang68@student.com'],
            ['name' => 'ឧត្តម វិសាល', 'name_en' => 'Odom Visal', 'email' => 'odomvisal99@student.com'],
            ['name' => 'វិបុល រតនៈ', 'name_en' => 'Vibol Ratanak', 'email' => 'vibolratanak94@student.com'],
            ['name' => 'សំណាង ឧត្តម', 'name_en' => 'Samnang Odom', 'email' => 'samnangodom41@student.com'],
            ['name' => 'សុខ ម៉ារី', 'name_en' => 'Sok Mary', 'email' => 'sokmary41@student.com'],
            ['name' => 'ចាន់ ស្រីនាថ', 'name_en' => 'Chan Sreynath', 'email' => 'chansreynath29@student.com'],
            ['name' => 'វណ្ណា សុភី', 'name_en' => 'Vanna Sophy', 'email' => 'vannasophy76@student.com'],
            ['name' => 'រតនា ទេវី', 'name_en' => 'Ratana Devi', 'email' => 'ratanadevi88@student.com'],
            ['name' => 'ស្រីល័ក្ខ សុជាតា', 'name_en' => 'Sreyleak Socheata', 'email' => 'sreyleaksocheata10@student.com'],
            ['name' => 'ម៉ៅ ពិសី', 'name_en' => 'Mao Pisey', 'email' => 'maopisey46@student.com'],
            ['name' => 'ផល្លា វិសិដ្ឋ', 'name_en' => 'Phalla Viseth', 'email' => 'phallaviseth43@student.com'],
            ['name' => 'ឡាយ ស៊ីណាត', 'name_en' => 'Lay Sinath', 'email' => 'laysinath86@student.com'],
            ['name' => 'ឃុន ស្រីរ័ត្ន', 'name_en' => 'Khun Sreyrath', 'email' => 'khunsreyrath79@student.com'],
            ['name' => 'ជា កល្យាណ', 'name_en' => 'Chea Kalyan', 'email' => 'cheakalyan42@student.com'],
            ['name' => 'ពេជ្រ ធីតា', 'name_en' => 'Pich Thida', 'email' => 'pichthida24@student.com'],
            ['name' => 'ណារី វិច្ឆិកា', 'name_en' => 'Nary Vicheka', 'email' => 'naryvicheka15@student.com'],
            ['name' => 'គង់ សុភ័ក្ត្រា', 'name_en' => 'Kong Sopheaktra', 'email' => 'kongsopheaktra94@student.com'],
            ['name' => 'សុខា ស្រីមុំ', 'name_en' => 'Sokha Sreymom', 'email' => 'okhasreymom65@student.com'],
            ['name' => 'តុលា ស្រីនី', 'name_en' => 'Tola Sreyny', 'email' => 'tolasreyny25@student.com'],
            ['name' => 'ឆៃយ៉ា រចនា', 'name_en' => 'Chaiya Rachana', 'email' => 'chaiyarachana61@student.com'],
            ['name' => 'សម្បត្តិ កញ្ញា', 'name_en' => 'Sambath Kanya', 'email' => 'sambathkanya37@student.com'],
            ['name' => 'ធីតា ទេពី', 'name_en' => 'Thida Tepey', 'email' => 'thidatepey72@student.com'],
            ['name' => 'ម៉ានី ស្រីឡែន', 'name_en' => 'Many Sreylen', 'email' => 'manysreylen80@student.com'],
            ['name' => 'វីរៈ សោភា', 'name_en' => 'Virak Sophea', 'email' => 'viraksophea76@student.com'],
            ['name' => 'រតនៈ វិសាល', 'name_en' => 'Ratanak Visal', 'email' => 'ratanakvisal51@student.com'],
            ['name' => 'ចាន់ តារា', 'name_en' => 'Chan Dara', 'email' => 'chandara20@student.com'],
            ['name' => 'វណ្ណឌី សុភ័ក្ត្រ', 'name_en' => 'Vanndy Sopheak', 'email' => 'vanndysopheak38@student.com'],
            ['name' => 'រតនៈ វិសាល', 'name_en' => 'Ratanak Visal', 'email' => 'ratanakvisal56@student.com'],
            ['name' => 'សុភ័ណ្ឌ បញ្ញា', 'name_en' => 'Sophoan Panha', 'email' => 'sophoanpanha76@student.com'],
            ['name' => 'ម៉ៅ សំណាង', 'name_en' => 'Mao Samnang', 'email' => 'maosamnang17@student.com'],
            ['name' => 'ហេង ពិសិដ្ឋ', 'name_en' => 'Heng Piseth', 'email' => 'hengpiseth79@student.com'],
            ['name' => 'ឡាយ ហួត', 'name_en' => 'Lay Huot', 'email' => 'layhuot30@student.com'],
            ['name' => 'ឃុន វឌ្ឍនៈ', 'name_en' => 'Khun Vattanac', 'email' => 'khunvattanac72@student.com'],
            ['name' => 'ជា សុខខេង', 'name_en' => 'Chea Sokkheng', 'email' => 'cheasokkheng23@student.com'],
            ['name' => 'សុខ ចាន់ដារ៉ា', 'name_en' => 'Sok Chandara', 'email' => 'sokchandara29@student.com'],
            ['name' => 'ហេង ភារម្យ', 'name_en' => 'Heng Phearom', 'email' => 'hengphearom17@student.com'],
            ['name' => 'ចាន់ វីរៈ', 'name_en' => 'Chan Virak', 'email' => 'chanvirak28@student.com'],
            ['name' => 'វណ្ណឌី សុភ័ក្ត្រ', 'name_en' => 'Vanndy Sopheak', 'email' => 'vanndysopheak70@student.com'],
            ['name' => 'សុខ មីនា', 'name_en' => 'Sok Meana', 'email' => 'sokmeana10@student.com'],
            ['name' => 'សុភ័ណ្ឌ បញ្ញា', 'name_en' => 'Sophoan Panha', 'email' => 'sophoanpanha97@student.com'],
            ['name' => 'ឡាយ ហួត', 'name_en' => 'Lay Huot', 'email' => 'layhuot40@student.com'],
            ['name' => 'ឃុន វឌ្ឍនៈ', 'name_en' => 'Khun Vattanac', 'email' => 'khunvattanac51@student.com'],
            ['name' => 'ពេជ្រ សម្បត្តិ', 'name_en' => 'Pich Sambath', 'email' => 'pichsambath46@student.com'],
            ['name' => 'ណារិទ្ធ វិបុល', 'name_en' => 'Narith Vibol', 'email' => 'narithvibol65@student.com'],
            ['name' => 'គង់ ម៉េងហុង', 'name_en' => 'Kong Menghong', 'email' => 'kongmenghong40@student.com'],
            ['name' => 'ឆៃយ៉ា រិទ្ធី', 'name_en' => 'Chaiya Rithy', 'email' => 'chaiyarithy98@student.com'],
            ['name' => 'សម្បត្តិ ឧត្តម', 'name_en' => 'Sambath Odom', 'email' => 'sambathodom52@student.com'],
            ['name' => 'ម៉ានិត សិលា', 'name_en' => 'Manit Sela', 'email' => 'manitsela74@student.com'],
            ['name' => 'ភារៈ សុជាតិ', 'name_en' => 'Phearak Socheat', 'email' => 'phearaksocheat43@student.com'],
            ['name' => 'ភក្តី សិរីវឌ្ឍន៍', 'name_en' => 'Pheakdei Sereyvathanac', 'email' => 'pheakdeisereyvathanac84@student.com'],
            ['name' => 'សុវណ្ណ រិទ្ធ', 'name_en' => 'Sovann Rith', 'email' => 'sovannrith18@student.com'],
            ['name' => 'សុភ័ណ្ឌ បញ្ញា', 'name_en' => 'Sophoan Panha', 'email' => 'sophoanpanha97@student.com'],
            ['name' => 'ម៉ៅ សំណាង', 'name_en' => 'Mao Samnang', 'email' => 'maosamnang17@student.com']
        ];

        foreach ($students as $student) {
            DB::table('students')->updateOrInsert(
                ['email' => $student['email']], 
                [
                    'name' => $student['name'],
                    'name_en' => $student['name_en'],
                    'phone' => '012' . rand(100000, 999999),
                    'gender' => 'Other',
                    'address' => 'Phnom Penh, Cambodia',
                    'score' => rand(40, 100),
                    'date_of_birth' => now()->subYears(rand(6, 25))->toDateString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
