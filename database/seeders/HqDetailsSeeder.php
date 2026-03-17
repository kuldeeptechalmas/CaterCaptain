<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HqDetailsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('hq_details')->upsert(
            [
                ['key' => 'name', 'value' => 'CaterCaptain HQ', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'street', 'value' => 'Navrangpura', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'city', 'value' => 'Ahmedabad', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'state', 'value' => 'Gujarat', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'pincode', 'value' => '380009', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'country', 'value' => 'India', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'phone', 'value' => '9876543210', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'email', 'value' => 'hq@catercaptain.com', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'gstin', 'value' => '24ABCDE1234F1Z5', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'pan', 'value' => 'ABCDE1234F', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'is_active', 'value' => '1', 'created_at' => $now, 'updated_at' => $now],
            ],
            ['key'],
            ['value', 'updated_at']
        );
    }
}
