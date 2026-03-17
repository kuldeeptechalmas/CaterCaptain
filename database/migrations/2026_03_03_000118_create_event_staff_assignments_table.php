<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_staff_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_service_id')->constrained('event_services')->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('staff');
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->decimal('labour_cost', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_staff_assignments');
    }
};
