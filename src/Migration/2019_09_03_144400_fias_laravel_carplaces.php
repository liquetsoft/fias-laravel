<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'CARPLACES'.
 */
class Fiaslaravelcarplaces extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_carplaces'.
     */
    public function up(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_carplaces');
        Schema::connection($connectionName)->create('fias_laravel_carplaces', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('id')->nullable(false)->comment('Уникальный идентификатор записи. Ключевое поле')->primary();
            $table->unsignedInteger('objectid')->nullable(false)->comment('Глобальный уникальный идентификатор объекта типа INTEGER');
            $table->uuid('objectguid')->nullable(false)->comment('Глобальный уникальный идентификатор адресного объекта типа UUID');
            $table->unsignedInteger('changeid')->nullable(false)->comment('ID изменившей транзакции');
            $table->string('number', 50)->nullable(false)->comment('Номер машиноместа');
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
     * Удаление таблицы 'fias_laravel_carplaces'.
     */
    public function down(): void
    {
        /** @var string|null */
        $connectionName = config('liquetsoft_fias.eloquent_connection');

        Schema::connection($connectionName)->dropIfExists('fias_laravel_carplaces');
    }
}
