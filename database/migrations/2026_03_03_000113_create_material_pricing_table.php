<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raw_material_id')->constrained('raw_materials');
            $table->foreignId('unit_id')->constrained('units');
            $table->date('pricing_date')->index();
            $table->decimal('price_unit', 10, 2)->default(0);
            $table->decimal('price_kg', 10, 2)->nullable();
            $table->decimal('price_litre', 10, 2)->nullable();
            $table->decimal('price_piece', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_pricing');
    }
};
