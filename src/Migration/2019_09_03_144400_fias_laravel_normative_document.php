<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'NormativeDocument'.
 */
class FiasLaravelNormativeDocument extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_normative_document'.
     */
    public function up(): void
    {
        Schema::dropIfExists('fias_laravel_normative_document');
        Schema::create('fias_laravel_normative_document', function (Blueprint $table) {
            // создание полей таблицы
            $table->uuid('normdocid')->nullable(false)->comment('Идентификатор нормативного документа')->primary();
            $table->text('docname')->nullable(true)->comment('Наименование документа');
            $table->datetime('docdate')->nullable(true)->comment('Дата документа');
            $table->string('docnum', 250)->nullable(true)->comment('Номер документа');
            $table->unsignedInteger('doctype')->nullable(false)->comment('Тип документа');
            $table->uuid('docimgid')->nullable(true)->comment('Идентификатор образа (внешний ключ)');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_normative_document'.
     */
    public function down(): void
    {
        Schema::dropIfExists('fias_laravel_normative_document');
    }
}
