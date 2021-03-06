<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'CurrentStatus'.
 */
class FiasLaravelCurrentStatus extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_current_status'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_current_status');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_current_status', function (Blueprint $table) {
            // создание полей таблицы
            $table->unsignedInteger('curentstid')->nullable(false)->comment('Идентификатор статуса (ключ)')->primary();
            $table->string('name', 100)->nullable(false)->comment('Наименование (0 - актуальный, 1-50, 2-98 – исторический (кроме 51), 51 - переподчиненный, 99 - несуществующий)');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_current_status'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_current_status');
    }
}
