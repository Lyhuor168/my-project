<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            ['kh' => 'សុខ ចាន់ដារ៉ា', 'en' => 'Sok Chandara'],
            ['kh' => 'ហេង ភារម្យ', 'en' => 'Heng Phearom'],
            ['kh' => 'ចាន់ វីរៈ', 'en' => 'Chan Virak'],
            ['kh' => 'វណ្ណឌី សុភ័ក្ត្រ', 'en' => 'Vanndy Sopheak'],
            ['kh' => 'រតនៈ វិសាល', 'en' => 'Ratanak Visal'],
            ['kh' => 'សុភ័ណ្ឌ បញ្ញា', 'en' => 'Sophoan Panha'],
            ['kh' => 'ឡាយ ហួត', 'en' => 'Lay Huot'],
            ['kh' => 'ឃុន វឌ្ឍនៈ', 'en' => 'Khun Vattanac'],
            ['kh' => 'ពេជ្រ សម្បត្តិ', 'en' => 'Pich Sambath'],
            ['kh' => 'ណារិទ្ធ វិបុល', 'en' => 'Narith Vibol'],
            ['kh' => 'គង់ ម៉េងហុង', 'en' => 'Kong Menghong'],
            ['kh' => 'ឆៃយ៉ា រិទ្ធី', 'en' => 'Chaiya Rithy'],
            ['kh' => 'សម្បត្តិ ឧត្តម', 'en' => 'Sambath Odom'],
            ['kh' => 'ម៉ានិត សិលា', 'en' => 'Manit Sela'],
            ['kh' => 'ភារៈ សុជាតិ', 'en' => 'Phearak Socheat'],
            ['kh' => 'ភក្តី សិរីវឌ្ឍន៍', 'en' => 'Pheakdei Sereyvathanac'],
            ['kh' => 'សុវណ្ណ រិទ្ធ', 'en' => 'Sovann Rith'],
            ['kh' => 'ផល្លា វិសិដ្ឋ', 'en' => 'Phalla Viseth'],
            ['kh' => 'កុសល សុវត្ថិ', 'en' => 'Kosal Sovath'],
            ['kh' => 'ធារ៉ា សិរី', 'en' => 'Theara Serei'],
            ['kh' => 'វឌ្ឍនៈ ពិសិដ្ឋ', 'en' => 'Vattanac Piseth'],
            ['kh' => 'រិទ្ធី សំណាង', 'en' => 'Rithy Samnang'],
            ['kh' => 'ឧត្តម វិសាល', 'en' => 'Odom Visal'],
            ['kh' => 'វិបុល រតនៈ', 'en' => 'Vibol Ratanak'],
            ['kh' => 'សំណាង ឧត្តម', 'en' => 'Samnang Odom'],
            ['kh' => 'សុខ ម៉ារី', 'en' => 'Sok Mary'],
            ['kh' => 'ចាន់ ស្រីនាថ', 'en' => 'Chan Sreynath'],
            ['kh' => 'វណ្ណា សុភី', 'en' => 'Vanna Sophy'],
            ['kh' => 'រតនា ទេវី', 'en' => 'Ratana Devi'],
            ['kh' => 'ស្រីល័ក្ខ សុជាតា', 'en' => 'Sreyleak Socheata'],
            ['kh' => 'ម៉ៅ ពិសី', 'en' => 'Mao Pisey'],
            ['kh' => 'ហេង ចរិយា', 'en' => 'Heng Chariya'],
            ['kh' => 'ឡាយ ស៊ីណាត', 'en' => 'Lay Sinath'],
            ['kh' => 'ឃុន ស្រីរ័ត្ន', 'en' => 'Khun Sreyrath'],
            ['kh' => 'ជា កល្យាណ', 'en' => 'Chea Kalyan'],
            ['kh' => 'ពេជ្រ ធីតា', 'en' => 'Pich Thida'],
            ['kh' => 'ណារី វិច្ឆិកា', 'en' => 'Nary Vicheka'],
            ['kh' => 'គង់ សុភ័ក្ត្រា', 'en' => 'Kong Sopheaktra'],
            ['kh' => 'សុខា ស្រីមុំ', 'en' => 'Sokha Sreymom'],
            ['kh' => 'តុលា ស្រីនី', 'en' => 'Tola Sreyny'],
            ['kh' => 'ឆៃយ៉ា រចនា', 'en' => 'Chaiya Rachana'],
            ['kh' => 'សម្បត្តិ កញ្ញា', 'en' => 'Sambath Kanya'],
            ['kh' => 'ធីតា ទេពី', 'en' => 'Thida Tepey'],
            ['kh' => 'ម៉ានី ស្រីឡែន', 'en' => 'Many Sreylen'],
            ['kh' => 'វីរៈ សោភា', 'en' => 'Virak Sophea'],
        ];

        foreach ($teachers as $teacher) {
            // បង្កើត Email ជាអក្សរតូច និងគ្មានចន្លោះ (ឧទាហរណ៍៖ sokchandara@school.com)
            $emailName = strtolower(str_replace(' ', '', $teacher['en']));
            
            // ក្នុង TeacherSeeder.php ត្រង់ loop insert
            // ក្នុង TeacherSeeder.php
            DB::table('teachers')->insertOrIgnore([
                'name' => $teacher['kh'],
                'name_en' => $teacher['en'],
                'email' => $emailName . '@school.com',
                'phone' => '012' . rand(100000, 999999),
                'gender' => 'Male',
                'subject' => 'Web Development', // <--- ដាក់តម្លៃលំនាំដើមសិន
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}