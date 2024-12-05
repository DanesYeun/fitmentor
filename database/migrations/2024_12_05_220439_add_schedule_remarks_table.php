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
            $table->string('day', 20)->nullable(); 
            $table->string('remarks', 255)->nullable(); 
    
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade'); 
    
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
