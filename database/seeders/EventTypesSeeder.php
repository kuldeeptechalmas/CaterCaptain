<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('event_types')->upsert([
            ['name' => 'Wedding', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Corporate', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Birthday', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Party', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ], ['name'], ['is_active', 'updated_at']);
    }
}
