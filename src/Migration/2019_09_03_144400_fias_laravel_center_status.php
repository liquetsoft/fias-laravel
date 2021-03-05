<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'CenterStatus'.
 */
class FiasLaravelCenterStatus extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_center_status'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_center_status');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_center_status', function (Blueprint $table) {
            // создание полей таблицы
            $table->unsignedInteger('centerstid')->nullable(false)->comment('Идентификатор статуса')->primary();
            $table->string('name', 100)->nullable(false)->comment('Наименование');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_center_status'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_center_status');
    }
}
