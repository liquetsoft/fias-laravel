<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'NormativeDocument'.
 */
class NormativeDocument1567520703 extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_normative_document'.
     */
    public function up(): void
    {
        Schema::create('fias_laravel_normative_document', function (Blueprint $table) {
            // создание полей таблицы
            $table->string('normdocid', 255)->nullable(false);
            $table->string('docname', 1000)->nullable(false);
            $table->datetime('docdate')->nullable(false);
            $table->string('docnum', 255)->nullable(false);
            $table->string('doctype', 255)->nullable(false);
            // создание индексов таблицы
            $table->primary('normdocid');
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
