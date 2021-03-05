<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'NormativeDocumentType'.
 */
class FiasLaravelNormativeDocumentType extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_normative_document_type'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_normative_document_type');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_normative_document_type', function (Blueprint $table) {
            // создание полей таблицы
            $table->unsignedInteger('ndtypeid')->nullable(false)->comment('Идентификатор записи (ключ)')->primary();
            $table->string('name', 250)->nullable(false)->comment('Наименование типа нормативного документа');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_normative_document_type'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_normative_document_type');
    }
}
