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
        Schema::create('attendance_settings', function (Blueprint $table) {
            $table->id();
            $table->time('morning_check_in')->default('08:00:00');
            $table->time('morning_check_out')->default('11:00:00');
            $table->time('afternoon_check_in')->default('13:00:00');
            $table->time('afternoon_check_out')->default('17:00:00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_settings');
    }
};