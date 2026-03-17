<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('inv_no', 30)->unique();
            $table->foreignId('event_id')->constrained('events');
            $table->date('inv_date')->index();
            $table->date('due_date')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2);
            $table->decimal('paid', 12, 2)->default(0);
            $table->text('bill_address')->nullable();
            $table->string('bill_phone', 15)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
