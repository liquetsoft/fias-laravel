<?php

declare(strict_types=1);

use Illuminate\Database\Connection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'Room'.
 */
class FiasLaravelRoom extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_room'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_room');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_room', function (Blueprint $table) {
            // создание полей таблицы
            $table->uuid('roomid')->nullable(false)->comment('Уникальный идентификатор записи. Ключевое поле.')->primary();
            $table->uuid('roomguid')->nullable(false)->comment('Глобальный уникальный идентификатор адресного объекта (помещения)');
            $table->uuid('houseguid')->nullable(false)->comment('Идентификатор родительского объекта (дома)');
            $table->string('regioncode', 2)->nullable(false)->comment('Код региона');
            $table->string('flatnumber', 50)->nullable(false)->comment('Номер помещения или офиса');
            $table->unsignedInteger('flattype')->nullable(false)->comment('Тип помещения');
            $table->string('postalcode', 6)->nullable(true)->comment('Почтовый индекс');
            $table->datetime('startdate')->nullable(false)->comment('Начало действия записи');
            $table->datetime('enddate')->nullable(false)->comment('Окончание действия записи');
            $table->datetime('updatedate')->nullable(false)->comment('Дата  внесения записи');
            $table->unsignedInteger('operstatus')->nullable(false)->comment('Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus): 01 – Инициация; 10 – Добавление; 20 – Изменение; 21 – Групповое изменение; 30 – Удаление; 31 - Удаление вследствие удаления вышестоящего объекта; 40 – Присоединение адресного объекта (слияние); 41 – Переподчинение вследствие слияния вышестоящего объекта; 42 - Прекращение существования вследствие присоединения к другому адресному объекту; 43 - Создание нового адресного объекта в результате слияния адресных объектов; 50 – Переподчинение; 51 – Переподчинение вследствие переподчинения вышестоящего объекта; 60 – Прекращение существования вследствие дробления; 61 – Создание нового адресного объекта в результате дробления');
            $table->unsignedInteger('livestatus')->nullable(false)->comment('Признак действующего адресного объекта');
            $table->uuid('normdoc')->nullable(true)->comment('Внешний ключ на нормативный документ');
            $table->string('roomnumber', 50)->nullable(true)->comment('Номер комнаты');
            $table->unsignedInteger('roomtype')->nullable(true)->comment('Тип комнаты');
            $table->uuid('previd')->nullable(true)->comment('Идентификатор записи связывания с предыдушей исторической записью');
            $table->uuid('nextid')->nullable(true)->comment('Идентификатор записи  связывания с последующей исторической записью');
            $table->string('cadnum', 100)->nullable(true)->comment('Кадастровый номер помещения');
            $table->string('roomcadnum', 100)->nullable(true)->comment('Кадастровый номер комнаты в помещении');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });

        //для mysql большие таблицы нужно разбивать на части
        $connection = DB::connection(config('liquetsoft_fias.eloquent_connection'));
        if ($connection instanceof Connection && $connection->getDriverName() === 'mysql') {
            //разбиваем таблицу на части
            $connection->unprepared('ALTER TABLE fias_laravel_room PARTITION BY KEY() PARTITIONS 4;');
        }
    }

    /**
     * Удаление таблицы 'fias_laravel_room'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_room');
    }
}
