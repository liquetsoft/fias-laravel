<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'AddressObjectType'.
 */
class AddressObjectType20190903144400 extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_address_object_type'.
     */
    public function up(): void
    {
        Schema::create('fias_laravel_address_object_type', function (Blueprint $table) {
            // создание полей таблицы
            $table->unsignedInteger('kod_t_st')->nullable(false);
            $table->unsignedInteger('level')->nullable(false);
            $table->string('socrname', 255)->nullable(false);
            $table->string('scname', 255)->nullable(false);
            // создание индексов таблицы
            $table->primary('kod_t_st');
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_address_object_type'.
     */
    public function down(): void
    {
        Schema::dropIfExists('fias_laravel_address_object_type');
    }
}
