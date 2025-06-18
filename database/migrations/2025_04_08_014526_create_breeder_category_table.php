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
        Schema::create('breeder_category', function (Blueprint $table) {
            $table->foreignId('breeder_id')->constrained('breeder_profiles')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('breeder_categories')->onDelete('cascade');
            $table->primary(['breeder_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breeder_category');
    }
};
