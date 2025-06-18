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
        Schema::create('puppy_siblings', function (Blueprint $table) {
            $table->foreignId('puppy_id')->constrained('puppies')->onDelete('cascade');
            $table->foreignId('sibling_id')->constrained('puppies')->onDelete('cascade');
            $table->primary(['puppy_id', 'sibling_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puppy_siblings');
    }
};
