<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('books')->insert([
            ['title' => 'Laravel សម្រាប់អ្នកចាប់ផ្តើម', 'author' => 'សុខ សុភា', 'category' => 'IT', 'language' => 'khmer', 'price' => 15.00, 'stock' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'PHP & MySQL', 'author' => 'លី មករា', 'category' => 'IT', 'language' => 'khmer', 'price' => 12.00, 'stock' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'គណិតវិទ្យាកម្រិតទី១២', 'author' => 'ចាន់ ដារ៉ា', 'category' => 'Science', 'language' => 'khmer', 'price' => 8.00, 'stock' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'English Grammar', 'author' => 'គឹម សុខា', 'category' => 'Language', 'language' => 'english', 'price' => 10.00, 'stock' => 40, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}