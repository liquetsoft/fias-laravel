<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'OperationStatus'.
 */
class FiasLaravelOperationStatus extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_operation_status'.
     */
    public function up(): void
    {
        Schema::dropIfExists('fias_laravel_operation_status');
        Schema::create('fias_laravel_operation_status', function (Blueprint $table) {
            // создание полей таблицы
            $table->unsignedInteger('operstatid')->nullable(false)->comment('Идентификатор статуса (ключ)')->primary();
            $table->string('name', 100)->nullable(false)->comment('Наименование 01 – Инициация; 10 – Добавление; 20 – Изменение; 21 – Групповое изменение; 30 – Удаление; 31 - Удаление вследствие удаления вышестоящего объекта; 40 – Присоединение адресного объекта (слияние); 41 – Переподчинение вследствие слияния вышестоящего объекта; 42 - Прекращение существования вследствие присоединения к другому адресному объекту; 43 - Создание нового адресного объекта в результате слияния адресных объектов; 50 – Переподчинение; 51 – Переподчинение вследствие переподчинения вышестоящего объекта; 60 – Прекращение существования вследствие дробления; 61 – Создание нового адресного объекта в результате дробления; 70 – Восстановление объекта прекратившего существование');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_operation_status'.
     */
    public function down(): void
    {
        Schema::dropIfExists('fias_laravel_operation_status');
    }
}
