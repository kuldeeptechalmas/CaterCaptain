<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('categories')->upsert([
            ['name' => 'Main Course', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dessert', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Starter', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Bread', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Beverage', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ], ['name'], ['is_active', 'updated_at']);
    }
}
