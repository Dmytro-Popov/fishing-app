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
            $table->decimal('temperature', 4, 1)->nullable();
            $table->string('weather_condition', 100)->nullable();
            $table->decimal('wind_speed', 4, 1)->nullable();
            $table->integer('pressure')->nullable();
            $table->integer('humidity')->nullable();
            $table->string('weather_source', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catches', function (Blueprint $table) {
            $table->dropColumn(['temperature', 'weather_condition', 'wind_speed', 'pressure', 'humidity', 'weather_source']);
        });
    }
};
