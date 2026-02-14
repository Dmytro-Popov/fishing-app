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
        Schema::create('catches', function (Blueprint $table) {
            $table->id();
            $table->date('date');                  // Дата рыбалки
            $table->string('location');            // Место (текст до 255 символов)
            $table->string('tackle');              // Снасть
            $table->string('bait');                // Наживка
            $table->string('species');             // Вид рыбы
            $table->decimal('weight', 5, 2)->nullable(); // Вес (например, 12.50 кг, может быть пустым)
            $table->timestamps();                  // created_at, updated_at (автоматически)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catches');
    }
};
