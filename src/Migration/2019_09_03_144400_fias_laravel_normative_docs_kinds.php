<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'NORMATIVE_DOCS_KINDS'.
 */
class Fiaslaravelnormativedocskinds extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_normative_docs_kinds'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_normative_docs_kinds');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_normative_docs_kinds', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('id')->nullable(false)->comment('Идентификатор записи')->primary();
            $table->text('name')->nullable(false)->comment('Наименование');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_normative_docs_kinds'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_normative_docs_kinds');
    }
}
