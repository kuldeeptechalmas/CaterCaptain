<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->index();
            $table->foreignId('event_type_id')->constrained('event_types');
            $table->enum('schedule_type', ['oneday', 'multiday', 'contract'])->index();
            $table->date('start_date')->index();
            $table->date('end_date')->nullable()->index();
            $table->dateTime('start_datetime')->nullable();
            $table->enum('status', ['Draft', 'Pending', 'Ongoing', 'Completed'])->index();
            $table->foreignId('kitchen_id')->constrained('kitchens');
            $table->string('client_name', 100)->index();
            $table->string('client_email', 100)->nullable();
            $table->string('client_phone', 15);
            $table->text('client_address')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
