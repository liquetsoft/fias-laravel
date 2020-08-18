<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'ActualStatus'.
 */
class FiasLaravelActualStatus extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_actual_status'.
     */
    public function up(): void
    {
        Schema::dropIfExists('fias_laravel_actual_status');
        Schema::create('fias_laravel_actual_status', function (Blueprint $table) {
            // создание полей таблицы
            $table->unsignedInteger('actstatid')->nullable(false)->comment('Идентификатор статуса (ключ)')->primary();
            $table->string('name', 100)->nullable(false)->comment('Наименование 0 – Не актуальный 1 – Актуальный (последняя запись по адресному объекту)');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
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
