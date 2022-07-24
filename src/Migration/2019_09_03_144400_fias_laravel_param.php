<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'PARAM'.
 */
class Fiaslaravelparam extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_param'.
     */
    public function up(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_param');
        Schema::connection($connectionName)->create('fias_laravel_param', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('id')->nullable(false)->comment('Идентификатор записи')->primary();
            $table->unsignedInteger('objectid')->nullable(false)->comment('Глобальный уникальный идентификатор адресного объекта');
            $table->unsignedInteger('changeid')->nullable(true)->comment('ID изменившей транзакции');
            $table->unsignedInteger('changeidend')->nullable(false)->comment('ID завершившей транзакции');
            $table->unsignedInteger('typeid')->nullable(false)->comment('Тип параметра');
            $table->text('value')->nullable(false)->comment('Значение параметра');
            $table->datetime('updatedate')->nullable(false)->comment('Дата внесения (обновления) записи');
            $table->datetime('startdate')->nullable(false)->comment('Дата начала действия записи');
            $table->datetime('enddate')->nullable(false)->comment('Дата окончания действия записи');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_param'.
     */
    public function down(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_param');
    }
}
