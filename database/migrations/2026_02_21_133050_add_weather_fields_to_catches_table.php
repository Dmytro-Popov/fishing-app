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
        Schema::table('catches', function (Blueprint $table) {
        if (!Schema::hasColumn('catches', 'temperature'))
            $table->decimal('temperature', 4, 1)->nullable();
        if (!Schema::hasColumn('catches', 'weather_condition'))
            $table->string('weather_condition', 100)->nullable();
        if (!Schema::hasColumn('catches', 'wind_speed'))
            $table->decimal('wind_speed', 4, 1)->nullable();
        if (!Schema::hasColumn('catches', 'pressure'))
            $table->integer('pressure')->nullable();
        if (!Schema::hasColumn('catches', 'humidity'))
            $table->integer('humidity')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catches', function (Blueprint $table) {
          $table->dropColumn(['temperature', 'weather_condition', 'wind_speed', 'pressure', 'humidity']);
        });
    }
};
