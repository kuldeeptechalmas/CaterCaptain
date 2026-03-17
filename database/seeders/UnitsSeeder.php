<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('units')->upsert([
            [
                'name' => 'Kilogram',
                'symbol' => 'kg',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Gram',
                'symbol' => 'g',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Liter',
                'symbol' => 'l',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Piece',
                'symbol' => 'pcs',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['name'], ['symbol', 'is_active', 'updated_at']);
    }
}
