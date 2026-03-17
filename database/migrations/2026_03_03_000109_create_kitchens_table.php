<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kitchens', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->string('street', 255)->nullable();
            $table->string('city', 100)->nullable()->index();
            $table->string('state', 100)->nullable();
            $table->string('pincode', 20)->nullable()->index();
            $table->string('country', 100)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kitchens');
    }
};
