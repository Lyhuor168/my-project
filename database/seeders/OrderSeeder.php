<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $names = ['សុខ សុភា', 'លី មករា', 'ចាន់ ដារ៉ា', 'គឹម សុខា', 'ហេង វិចិត្រ'];
        $methods = ['cash', 'aba', 'wing', 'acleda'];
        $statuses = ['pending', 'completed', 'cancelled'];

        for ($i = 0; $i < 30; $i++) {
            DB::table('orders')->insert([
                'customer_name'  => $names[array_rand($names)],
                'phone'          => '0' . rand(10000000, 99999999),
                'email'          => 'test' . $i . '@school.com',
                'quantity'       => rand(1, 5),
                'total_price'    => rand(5, 100) . '.00',
                'payment_method' => $methods[array_rand($methods)],
                'status'         => $statuses[array_rand($statuses)],
                'created_at'     => Carbon::now()->subDays(rand(0, 7)),
                'updated_at'     => now(),
            ]);
        }
    }
}
