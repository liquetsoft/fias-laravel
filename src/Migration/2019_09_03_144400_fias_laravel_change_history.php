<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'CHANGE_HISTORY'.
 */
class Fiaslaravelchangehistory extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_change_history'.
     */
    public function up(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_change_history');
        Schema::connection($connectionName)->create('fias_laravel_change_history', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('changeid')->nullable(false)->comment('ID изменившей транзакции')->primary();
            $table->unsignedInteger('objectid')->nullable(false)->comment('Уникальный ID объекта');
            $table->uuid('adrobjectid')->nullable(false)->comment('Уникальный ID изменившей транзакции (GUID)');
            $table->unsignedInteger('opertypeid')->nullable(false)->comment('Тип операции');
            $table->unsignedInteger('ndocid')->nullable(true)->comment('ID документа');
            $table->datetime('changedate')->nullable(false)->comment('Дата изменения');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_change_history'.
     */
    public function down(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_change_history');
    }
}
