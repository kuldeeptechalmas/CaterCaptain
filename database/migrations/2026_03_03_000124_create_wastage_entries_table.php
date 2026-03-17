<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wastage_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raw_material_id')->constrained('raw_materials');
            $table->foreignId('unit_id')->constrained('units');
            $table->decimal('qty', 12, 3);
            $table->date('wastage_date')->index();
            $table->string('reason', 50)->index();
            $table->text('note')->nullable();
            $table->foreignId('kitchen_id')->constrained('kitchens');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wastage_entries');
    }
};
