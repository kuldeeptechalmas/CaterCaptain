<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_request_lines', function (Blueprint $table) {
            $table->id();
            $table->string('material_request_id', 20)->index();
            $table->foreignId('raw_material_id')->constrained('raw_materials');
            $table->decimal('qty_requested', 12, 3);
            $table->decimal('qty_approved', 12, 3)->nullable();
            $table->decimal('qty_dispatched', 12, 3)->nullable();
            $table->decimal('qty_received', 12, 3)->nullable();
            $table->string('remarks', 255)->nullable();
            $table->decimal('available', 12, 3)->nullable();
            $table->decimal('rate', 10, 2)->nullable();
            $table->decimal('amount', 12, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('material_request_id')->references('id')->on('material_requests')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_request_lines');
    }
};
