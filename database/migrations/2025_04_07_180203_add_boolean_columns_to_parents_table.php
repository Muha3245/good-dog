<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('parents', function (Blueprint $table) {
            $table->boolean('is_cuddly_champion')->default(false);
            $table->boolean('is_good_with_families')->default(false);
            $table->boolean('is_great_for_allergy_sufferers')->default(false);
        });
    }

    public function down()
    {
        Schema::table('parents', function (Blueprint $table) {
            $table->dropColumn([
                'is_cuddly_champion',
                'is_good_with_families',
                'is_great_for_allergy_sufferers'
            ]);
        });
    }
};