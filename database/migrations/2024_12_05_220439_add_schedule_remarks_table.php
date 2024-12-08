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
        Schema::create('schedule_remarks', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->unsignedBigInteger('schedule_id');
            $table->tinyInteger('week')->default(0);
            $table->time('sunday_start')->nullable();
            $table->time('sunday_end')->nullable();
            $table->time('monday_start')->nullable();
            $table->time('monday_end')->nullable();
            $table->time('tuesday_start')->nullable();
            $table->time('tuesday_end')->nullable();
            $table->time('wednesday_start')->nullable();
            $table->time('wednesday_end')->nullable();
            $table->time('thursday_start')->nullable();
            $table->time('thursday_end')->nullable();
            $table->time('friday_start')->nullable();
            $table->time('friday_end')->nullable();
            $table->time('saturday_start')->nullable();
            $table->time('saturday_end')->nullable();
            $table->string('remarks', 255)->nullable(); 
            $table->unsignedTinyInteger('attendance_id');
    
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade'); 
            $table->foreign('attendance_id')->references('id')->on('attendance')->onDelete('cascade'); 
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_remarks');
    }
};
