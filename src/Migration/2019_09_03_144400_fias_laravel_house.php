<?php

declare(strict_types=1);

use Illuminate\Database\Connection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'House'.
 */
class FiasLaravelHouse extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_house'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_house');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_house', function (Blueprint $table) {
            // создание полей таблицы
            $table->uuid('houseid')->nullable(false)->comment('Уникальный идентификатор записи дома')->primary();
            $table->uuid('houseguid')->nullable(false)->comment('Глобальный уникальный идентификатор дома');
            $table->uuid('aoguid')->nullable(false)->comment('Guid записи родительского объекта (улицы, города, населенного пункта и т.п.)');
            $table->string('housenum', 20)->nullable(true)->comment('Номер дома');
            $table->unsignedInteger('strstatus')->nullable(true)->comment('Признак строения');
            $table->unsignedInteger('eststatus')->nullable(false)->comment('Признак владения');
            $table->unsignedInteger('statstatus')->nullable(false)->comment('Состояние дома');
            $table->string('ifnsfl', 4)->nullable(true)->comment('Код ИФНС ФЛ');
            $table->string('ifnsul', 4)->nullable(true)->comment('Код ИФНС ЮЛ');
            $table->string('okato', 11)->nullable(true)->comment('OKATO');
            $table->string('oktmo', 11)->nullable(true)->comment('OKTMO');
            $table->string('postalcode', 6)->nullable(true)->comment('Почтовый индекс');
            $table->datetime('startdate')->nullable(false)->comment('Начало действия записи');
            $table->datetime('enddate')->nullable(false)->comment('Окончание действия записи');
            $table->datetime('updatedate')->nullable(false)->comment('Дата время внесения записи');
            $table->unsignedInteger('counter')->nullable(false)->comment('Счетчик записей домов для КЛАДР 4');
            $table->unsignedInteger('divtype')->nullable(false)->comment('Тип адресации: 0 - не определено 1 - муниципальный; 2 - административно-территориальный');
            $table->string('regioncode', 2)->nullable(true)->comment('Код региона');
            $table->string('terrifnsfl', 4)->nullable(true)->comment('Код территориального участка ИФНС ФЛ');
            $table->string('terrifnsul', 4)->nullable(true)->comment('Код территориального участка ИФНС ЮЛ');
            $table->string('buildnum', 50)->nullable(true)->comment('Номер корпуса');
            $table->string('strucnum', 50)->nullable(true)->comment('Номер строения');
            $table->uuid('normdoc')->nullable(true)->comment('Внешний ключ на нормативный документ');
            $table->string('cadnum', 100)->nullable(true)->comment('Кадастровый номер');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });

        //для mysql большие таблицы нужно разбивать на части
        $connection = DB::connection();
        if ($connection instanceof Connection && $connection->getDriverName() === 'mysql') {
            //разбиваем таблицу на части
            DB::connection()->unprepared('ALTER TABLE fias_laravel_house PARTITION BY KEY() PARTITIONS 4;');
        }
    }

    /**
     * Удаление таблицы 'fias_laravel_house'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_house');
    }
}
