<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('location_id')->constrained('hq_details');
            $table->decimal('qty', 12, 3)->default(0);
            $table->decimal('min_qty', 12, 3)->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};
