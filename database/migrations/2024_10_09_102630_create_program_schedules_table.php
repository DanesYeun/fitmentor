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
    Schema::create('program_schedules', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('exercise_id');
        $table->unsignedBigInteger('schedule_id');
        $table->timestamps();

        // Foreign key constraints
        $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
        $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_schedules');
    }
};
