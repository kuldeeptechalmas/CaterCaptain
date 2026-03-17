<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KitchensSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('kitchens')->upsert([
            [
                'name' => 'Satellite Kitchen',
                'street' => 'Satellite Road',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380015',
                'country' => 'India',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Maninagar Kitchen',
                'street' => 'Maninagar',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380008',
                'country' => 'India',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['name'], ['street', 'city', 'state', 'pincode', 'country', 'is_active', 'updated_at']);
    }
}
