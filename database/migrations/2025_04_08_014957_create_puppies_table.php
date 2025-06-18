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
        Schema::create('puppies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('breeder_id')->constrained('breeder_profiles')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('breeder_categories')->onDelete('restrict');
            $table->foreignId('parentcat_id')->constrained('parents')->onDelete('restrict');
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('breed');
            $table->string('color');
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('status')->default('available'); // available, reserved, sold
            $table->string('main_image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('health_records')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puppies');
    }
};
