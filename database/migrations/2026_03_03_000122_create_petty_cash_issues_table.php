<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petty_cash_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('captain_id')->constrained('users');
            $table->decimal('amount', 12, 2);
            $table->date('issue_date')->index();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petty_cash_issues');
    }
};
