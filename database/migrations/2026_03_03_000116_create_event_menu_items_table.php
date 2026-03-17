<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_service_id')->constrained('event_services')->onDelete('cascade');
            $table->foreignId('dish_id')->constrained('dishes');
            $table->integer('qty')->default(0);
            $table->decimal('rate', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_menu_items');
    }
};
