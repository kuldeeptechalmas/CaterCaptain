<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DishesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $categoryIds = DB::table('categories')->pluck('id', 'name');

        $dishes = [
            ['dish' => 'Paneer Butter Masala', 'category' => 'Main Course', 'rate' => 180.00],
            ['dish' => 'Veg Biryani', 'category' => 'Main Course', 'rate' => 160.00],
            ['dish' => 'Dal Tadka', 'category' => 'Main Course', 'rate' => 120.00],
            ['dish' => 'Gulab Jamun', 'category' => 'Dessert', 'rate' => 70.00],
            ['dish' => 'Rasgulla', 'category' => 'Dessert', 'rate' => 75.00],
            ['dish' => 'Kaju Katli', 'category' => 'Dessert', 'rate' => 140.00],
            ['dish' => 'Hara Bhara Kabab', 'category' => 'Starter', 'rate' => 130.00],
            ['dish' => 'Paneer Tikka', 'category' => 'Starter', 'rate' => 170.00],
            ['dish' => 'Veg Spring Roll', 'category' => 'Starter', 'rate' => 125.00],
            ['dish' => 'Butter Naan', 'category' => 'Bread', 'rate' => 35.00],
            ['dish' => 'Tandoori Roti', 'category' => 'Bread', 'rate' => 20.00],
            ['dish' => 'Lachha Paratha', 'category' => 'Bread', 'rate' => 40.00],
            ['dish' => 'Masala Chaas', 'category' => 'Beverage', 'rate' => 25.00],
            ['dish' => 'Fresh Lime Soda', 'category' => 'Beverage', 'rate' => 45.00],
            ['dish' => 'Mango Lassi', 'category' => 'Beverage', 'rate' => 60.00],
        ];

        foreach ($dishes as $dish) {
            if (! isset($categoryIds[$dish['category']])) {
                continue;
            }

            DB::table('dishes')->updateOrInsert(
                [
                    'dish' => $dish['dish'],
                    'category_id' => $categoryIds[$dish['category']],
                ],
                [
                    'rate' => $dish['rate'],
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
