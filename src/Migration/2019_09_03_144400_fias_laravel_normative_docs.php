<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'NORMATIVE_DOCS'.
 */
class Fiaslaravelnormativedocs extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_normative_docs'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_normative_docs');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_normative_docs', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('id')->nullable(false)->comment('Уникальный идентификатор документа')->primary();
            $table->text('name')->nullable(false)->comment('Наименование документа');
            $table->datetime('date')->nullable(false)->comment('Дата документа');
            $table->string('number', 150)->nullable(false)->comment('Номер документа');
            $table->unsignedInteger('type')->nullable(false)->comment('Тип документа');
            $table->unsignedInteger('kind')->nullable(false)->comment('Вид документа');
            $table->datetime('updatedate')->nullable(false)->comment('Дата обновления');
            $table->string('orgname', 255)->nullable(true)->comment('Наименование органа создвшего нормативный документ');
            $table->string('regnum', 100)->nullable(true)->comment('Номер государственной регистрации');
            $table->datetime('regdate')->nullable(true)->comment('Дата государственной регистрации');
            $table->datetime('accdate')->nullable(true)->comment('Дата вступления в силу нормативного документа');
            $table->text('comment')->nullable(true)->comment('Комментарий');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_normative_docs'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_normative_docs');
    }
}
