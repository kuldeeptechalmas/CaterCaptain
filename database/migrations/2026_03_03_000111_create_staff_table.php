<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->foreignId('staff_role_id')->constrained('staff_roles');
            $table->string('phone', 15)->unique();
            $table->string('email', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('salary_type', 30);
            $table->decimal('rate', 10, 2);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
