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
        Schema::table('program_schedules', function (Blueprint $table) {
            
            $table->unsignedBigInteger('focus_area_id')->after('schedule_id')->nullable();

            $table->foreign('focus_area_id')->references('id')->on('focus_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_schedules', function (Blueprint $table) {
            //
        });
    }
};
