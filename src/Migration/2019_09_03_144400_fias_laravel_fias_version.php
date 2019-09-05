<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'FiasVersion'.
 */
class FiasVersion20190903144400 extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_fias_version'.
     */
    public function up(): void
    {
        Schema::create('fias_laravel_fias_version', function (Blueprint $table) {
            // создание полей таблицы
            $table->unsignedInteger('version')->nullable(false)->comment('Номер версии ФИАС');
            $table->string('url', 255)->nullable(false)->comment('Ссылка для загрузки указанной версии ФИАС');
            $table->string('created_at', 255)->nullable(false)->comment('Дата создания записи');
            // создание индексов таблицы
            $table->primary('version');
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_fias_version'.
     */
    public function down(): void
    {
        Schema::dropIfExists('fias_laravel_fias_version');
    }
}
