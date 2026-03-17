<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consumption_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kitchen_id')->constrained('kitchens');
            $table->foreignId('raw_material_id')->constrained('raw_materials');
            $table->foreignId('unit_id')->constrained('units');
            $table->date('entry_date')->index();
            $table->decimal('qty', 12, 3);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumption_entries');
    }
};
