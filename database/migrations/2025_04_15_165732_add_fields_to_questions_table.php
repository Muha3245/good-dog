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
        Schema::table('questions', function (Blueprint $table) {
            // Add new question types
            $table->enum('type', ['text', 'yes_no', 'file', 'description', 'select', 'radio', 'checkbox'])
                  ->default('text')
                  ->change();
            
            // Add options field for select/radio/checkbox types
            $table->text('options')->nullable()->after('type');
            
            // Add order field
            $table->integer('order')->default(0)->after('options');
            
            // Add is_required field
            $table->boolean('is_required')->default(false)->after('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // Revert to original enum values
            $table->enum('type', ['text', 'yes_no', 'file', 'description'])
                  ->default('text')
                  ->change();
            
            // Remove added columns
            $table->dropColumn(['options', 'order', 'is_required']);
        });
    }
};
