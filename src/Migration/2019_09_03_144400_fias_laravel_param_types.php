<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'PARAM_TYPES'.
 */
class Fiaslaravelparamtypes extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_param_types'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_param_types');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_param_types', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('id')->nullable(false)->comment('Идентификатор типа параметра (ключ)')->primary();
            $table->string('name', 50)->nullable(false)->comment('Наименование');
            $table->string('code', 50)->nullable(false)->comment('Краткое наименование');
            $table->string('desc', 120)->nullable(true)->comment('Описание');
            $table->datetime('updatedate')->nullable(false)->comment('Дата внесения (обновления) записи');
            $table->datetime('startdate')->nullable(false)->comment('Начало действия записи');
            $table->datetime('enddate')->nullable(false)->comment('Окончание действия записи');
            $table->string('isactive', 255)->nullable(false)->comment('Статус активности');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_param_types'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_param_types');
    }
}
