<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'OperationStatus'.
 */
class OperationStatus20190903144400 extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_operation_status'.
     */
    public function up(): void
    {
        Schema::create('fias_laravel_operation_status', function (Blueprint $table) {
            // создание полей таблицы
            $table->unsignedInteger('operstatid')->nullable(false);
            $table->string('name', 255)->nullable(false);
            // создание индексов таблицы
            $table->primary('operstatid');
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
