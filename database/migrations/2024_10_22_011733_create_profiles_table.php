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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('cell');
            $table->string('emergency');
            $table->integer('age');
            $table->string('gender');
            $table->string('address');
            $table->decimal('height', 5, 0); 
            $table->decimal('weight', 5, 0);
            $table->string('goal');
            $table->string('area');
            $table->string('level');
            $table->string('name');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
