<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id('seat_id');
            $table->foreignId('hall_id')->constrained('halls', 'hall_id')->cascadeOnDelete();
            $table->string('seat_number', 10);
            $table->string('row_number', 5);
            $table->enum('seat_type', ['standard', 'vip', 'wheelchair'])->default('standard');
            $table->unique(['hall_id', 'seat_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
