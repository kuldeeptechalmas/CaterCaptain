<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_material_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_service_id')->constrained('event_services')->onDelete('cascade');
            $table->foreignId('raw_material_id')->constrained('raw_materials');
            $table->foreignId('unit_id')->constrained('units');
            $table->decimal('required', 12, 3)->default(0);
            $table->decimal('total_material_cost', 12, 2)->default(0);
            $table->decimal('transportation_cost', 12, 2)->default(0);
            $table->decimal('other_cost', 12, 2)->default(0);
            $table->string('other_cost_note', 255)->nullable();
            $table->integer('labour_count')->default(0);
            $table->decimal('labour_cost_per', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_material_rows');
    }
};
