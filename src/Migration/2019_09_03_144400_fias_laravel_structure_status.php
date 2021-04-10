<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'StructureStatus'.
 */
class FiasLaravelStructureStatus extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_structure_status'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_structure_status');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_structure_status', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('strstatid')->nullable(false)->comment('Признак строения')->primary();
            $table->string('name', 20)->nullable(false)->comment('Наименование');
            $table->string('shortname', 20)->nullable(true)->comment('Краткое наименование');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_structure_status'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_structure_status');
    }
}
