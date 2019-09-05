<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'ActualStatus'.
 */
class ActualStatus20190903144400 extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_actual_status'.
     */
    public function up(): void
    {
        Schema::create('fias_laravel_actual_status', function (Blueprint $table) {
            // создание полей таблицы
            $table->unsignedInteger('actstatid')->nullable(false);
            $table->string('name', 255)->nullable(false);
            // создание индексов таблицы
            $table->primary('actstatid');
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_actual_status'.
     */
    public function down(): void
    {
        Schema::dropIfExists('fias_laravel_actual_status');
    }
}
