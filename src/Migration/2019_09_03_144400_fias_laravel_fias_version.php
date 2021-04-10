<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'FiasVersion'.
 */
class FiasLaravelFiasVersion extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_fias_version'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_fias_version');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_fias_version', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('version')->nullable(false)->comment('Номер версии ФИАС')->primary();
            $table->string('url', 255)->nullable(false)->comment('Ссылка для загрузки указанной версии ФИАС');
            $table->datetime('created_at')->nullable(false)->comment('Дата создания записи');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_fias_version'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_fias_version');
    }
}
