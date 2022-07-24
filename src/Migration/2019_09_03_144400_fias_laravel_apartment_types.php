<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'APARTMENT_TYPES'.
 */
class Fiaslaravelapartmenttypes extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_apartment_types'.
     */
    public function up(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_apartment_types');
        Schema::connection($connectionName)->create('fias_laravel_apartment_types', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('id')->nullable(false)->comment('Идентификатор типа (ключ)')->primary();
            $table->string('name', 50)->nullable(false)->comment('Наименование');
            $table->string('shortname', 50)->nullable(true)->comment('Краткое наименование');
            $table->string('desc', 250)->nullable(true)->comment('Описание');
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
     * Удаление таблицы 'fias_laravel_apartment_types'.
     */
    public function down(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_apartment_types');
    }
}
