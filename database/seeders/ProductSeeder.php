<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            ['shop_id' => 1, 'name_kh' => 'កុំព្យូទ័រយួរដៃ', 'name_en' => 'Laptop', 'price' => 599.99, 'created_at' => now(), 'updated_at' => now()],
            ['shop_id' => 1, 'name_kh' => 'កណ្តុរ', 'name_en' => 'Mouse', 'price' => 9.99, 'created_at' => now(), 'updated_at' => now()],
            ['shop_id' => 1, 'name_kh' => 'ក្តារចុច', 'name_en' => 'Keyboard', 'price' => 25.00, 'created_at' => now(), 'updated_at' => now()],
            ['shop_id' => 2, 'name_kh' => 'កាសស្តាប់', 'name_en' => 'Headphone', 'price' => 49.99, 'created_at' => now(), 'updated_at' => now()],
            ['shop_id' => 2, 'name_kh' => 'ថ្ម USB', 'name_en' => 'USB Drive', 'price' => 5.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

