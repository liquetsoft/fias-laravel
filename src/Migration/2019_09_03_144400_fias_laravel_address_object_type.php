<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'AddressObjectType'.
 */
class FiasLaravelAddressObjectType extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_address_object_type'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_address_object_type');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_address_object_type', function (Blueprint $table) {
            // создание полей таблицы
            $table->string('kod_t_st', 4)->nullable(false)->comment('Ключевое поле')->primary();
            $table->unsignedInteger('level')->nullable(false)->comment('Уровень адресного объекта');
            $table->string('socrname', 50)->nullable(false)->comment('Полное наименование типа объекта');
            $table->string('scname', 10)->nullable(true)->comment('Краткое наименование типа объекта');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_address_object_type'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_address_object_type');
    }
}
