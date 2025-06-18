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
        Schema::create('puppy_parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puppy_id')->constrained('puppies')->onDelete('cascade');
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->string('breed');
            $table->string('registration_number')->nullable();
            $table->text('genetic_tests')->nullable();
            $table->text('health_clearances')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puppy_parents');
    }
};
