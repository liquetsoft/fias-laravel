<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'REESTR_OBJECTS'.
 */
final class Fiaslaravelreestrobjects extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_reestr_objects'.
     */
    public function up(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_reestr_objects');
        Schema::connection($connectionName)->create('fias_laravel_reestr_objects', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('objectid')->nullable(false)->comment('Уникальный идентификатор объекта')->primary();
            $table->datetime('createdate')->nullable(false)->comment('Дата создания');
            $table->unsignedInteger('changeid')->nullable(false)->comment('ID изменившей транзакции');
            $table->unsignedInteger('levelid')->nullable(false)->comment('Уровень объекта');
            $table->datetime('updatedate')->nullable(false)->comment('Дата обновления');
            $table->uuid('objectguid')->nullable(false)->comment('GUID объекта');
            $table->unsignedInteger('isactive')->nullable(false)->comment('Признак действующего объекта (1 - действующий, 0 - не действующий)');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_reestr_objects'.
     */
    public function down(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_reestr_objects');
    }
}
