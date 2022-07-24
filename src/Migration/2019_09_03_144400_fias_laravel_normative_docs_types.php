<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'NORMATIVE_DOCS_TYPES'.
 */
class Fiaslaravelnormativedocstypes extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_normative_docs_types'.
     */
    public function up(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_normative_docs_types');
        Schema::connection($connectionName)->create('fias_laravel_normative_docs_types', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('id')->nullable(false)->comment('Идентификатор записи')->primary();
            $table->text('name')->nullable(false)->comment('Наименование');
            $table->datetime('startdate')->nullable(false)->comment('Дата начала действия записи');
            $table->datetime('enddate')->nullable(false)->comment('Дата окончания действия записи');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_normative_docs_types'.
     */
    public function down(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_normative_docs_types');
    }
}
