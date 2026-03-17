<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('raw_material_moment', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('raw_material_id');
            $table->foreign('raw_material_id')->references('id')->on('raw_materials');
            $table->decimal('qty', 12, 3)->default(0);
            $table->enum('status', ['in', 'out', 'wast', 'transfer'])->index();
            $table->foreignId('from_kitchen_id')->nullable()->constrained('kitchens');
            $table->foreignId('to_kitchen_id')->nullable()->constrained('kitchens');
            $table->foreignId('from_hq_id')->nullable()->constrained('hq_details');
            $table->foreignId('to_hq_id')->nullable()->constrained('hq_details');
            $table->string('note');
            $table->foreignId('unit_id')->constrained('units');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_material_moment');
    }
};
