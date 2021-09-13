<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'HOUSES'.
 */
class Fiaslaravelhouses extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_houses'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_houses');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_houses', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('id')->nullable(false)->comment('Уникальный идентификатор записи. Ключевое поле')->primary();
            $table->unsignedInteger('objectid')->nullable(false)->comment('Глобальный уникальный идентификатор объекта типа INTEGER');
            $table->uuid('objectguid')->nullable(false)->comment('Глобальный уникальный идентификатор адресного объекта типа UUID');
            $table->unsignedInteger('changeid')->nullable(false)->comment('ID изменившей транзакции');
            $table->string('housenum', 50)->nullable(true)->comment('Основной номер дома');
            $table->string('addnum1', 50)->nullable(true)->comment('Дополнительный номер дома 1');
            $table->string('addnum2', 50)->nullable(true)->comment('Дополнительный номер дома 1');
            $table->unsignedInteger('housetype')->nullable(true)->comment('Основной тип дома');
            $table->unsignedInteger('addtype1')->nullable(true)->comment('Дополнительный тип дома 1');
            $table->unsignedInteger('addtype2')->nullable(true)->comment('Дополнительный тип дома 2');
            $table->unsignedInteger('opertypeid')->nullable(false)->comment('Статус действия над записью – причина появления записи');
            $table->unsignedInteger('previd')->nullable(true)->comment('Идентификатор записи связывания с предыдущей исторической записью');
            $table->unsignedInteger('nextid')->nullable(true)->comment('Идентификатор записи связывания с последующей исторической записью');
            $table->datetime('updatedate')->nullable(false)->comment('Дата внесения (обновления) записи');
            $table->datetime('startdate')->nullable(false)->comment('Начало действия записи');
            $table->datetime('enddate')->nullable(false)->comment('Окончание действия записи');
            $table->unsignedInteger('isactual')->nullable(false)->comment('Статус актуальности адресного объекта ФИАС');
            $table->unsignedInteger('isactive')->nullable(false)->comment('Признак действующего адресного объекта');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_houses'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_houses');
    }
}
