<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'ADDR_OBJ_DIVISION'.
 */
class Fiaslaraveladdrobjdivision extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_addr_obj_division'.
     */
    public function up(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_addr_obj_division');
        Schema::connection($connectionName)->create('fias_laravel_addr_obj_division', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('id')->nullable(false)->comment('Уникальный идентификатор записи. Ключевое поле')->primary();
            $table->unsignedInteger('parentid')->nullable(false)->comment('Родительский ID');
            $table->unsignedInteger('childid')->nullable(false)->comment('Дочерний ID');
            $table->unsignedInteger('changeid')->nullable(false)->comment('ID изменившей транзакции');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_addr_obj_division'.
     */
    public function down(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_addr_obj_division');
    }
}
