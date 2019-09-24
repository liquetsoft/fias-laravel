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
            $table->uuid('normdocid')->nullable(false)->primary();
            $table->text('docname')->nullable(false);
            $table->datetime('docdate')->nullable(false);
            $table->string('docnum', 255)->nullable(false);
            $table->string('doctype', 255)->nullable(false);
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
