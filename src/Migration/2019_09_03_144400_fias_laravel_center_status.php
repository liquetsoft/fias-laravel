<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'CenterStatus'.
 */
class CenterStatus extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_center_status'.
     */
    public function up(): void
    {
        Schema::create('fias_laravel_center_status', function (Blueprint $table) {
            // создание полей таблицы
            $table->unsignedInteger('centerstid')->nullable(false);
            $table->string('name', 255)->nullable(false);
            // создание индексов таблицы
            $table->primary('centerstid');
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_center_status'.
     */
    public function down(): void
    {
        Schema::dropIfExists('fias_laravel_center_status');
    }
}
