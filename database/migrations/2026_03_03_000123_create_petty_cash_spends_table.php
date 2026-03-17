<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petty_cash_spends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('captain_id')->constrained('users');
            $table->decimal('amount', 12, 2);
            $table->string('note', 255);
            $table->date('spend_date')->index();
            $table->string('bill_photo', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petty_cash_spends');
    }
};
