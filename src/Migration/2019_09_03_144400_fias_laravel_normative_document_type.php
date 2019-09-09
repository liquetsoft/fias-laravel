<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'NormativeDocumentType'.
 */
class NormativeDocumentType extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_normative_document_type'.
     */
    public function up(): void
    {
        Schema::create('fias_laravel_normative_document_type', function (Blueprint $table) {
            // создание полей таблицы
            $table->unsignedInteger('ndtypeid')->nullable(false);
            $table->string('name', 255)->nullable(false);
            // создание индексов таблицы
            $table->primary('ndtypeid');
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_normative_document_type'.
     */
    public function down(): void
    {
        Schema::dropIfExists('fias_laravel_normative_document_type');
    }
}
