<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder {
    public function run(): void {
        DB::table('products')->insert([
            ['name'=>'Ice Latte',        'description'=>'Cold latte with ice',        'price'=>1.3, 'quantity'=>10, 'created_at'=>now(), 'updated_at'=>now()],
            ['name'=>'Vital',            'description'=>'Energy drink',               'price'=>0.5, 'quantity'=>15, 'created_at'=>now(), 'updated_at'=>now()],
            ['name'=>'Hot Latte',        'description'=>'Hot latte coffee',           'price'=>1.0, 'quantity'=>20, 'created_at'=>now(), 'updated_at'=>now()],
            ['name'=>'Hot Americano',    'description'=>'Hot americano coffee',       'price'=>1.0, 'quantity'=>20, 'created_at'=>now(), 'updated_at'=>now()],
            ['name'=>'Green Tea Frappe', 'description'=>'Green tea frappe drink',     'price'=>1.7, 'quantity'=>10, 'created_at'=>now(), 'updated_at'=>now()],
            ['name'=>'Ice Capuchino',    'description'=>'Cold capuchino with ice',    'price'=>1.5, 'quantity'=>10, 'created_at'=>now(), 'updated_at'=>now()],
        ]);
    }
}
