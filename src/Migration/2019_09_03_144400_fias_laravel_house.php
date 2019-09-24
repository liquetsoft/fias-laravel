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
        Schema::create('fias_laravel_house', function (Blueprint $table) {
            // создание полей таблицы
            $table->uuid('houseid')->nullable(false)->primary();
            $table->uuid('houseguid');
            $table->uuid('aoguid');
            $table->string('housenum', 20)->nullable(false);
            $table->unsignedInteger('strstatus')->nullable(false);
            $table->unsignedInteger('eststatus')->nullable(false);
            $table->unsignedInteger('statstatus')->nullable(false);
            $table->string('ifnsfl', 4)->nullable(false);
            $table->string('ifnsul', 4)->nullable(false);
            $table->string('okato', 11)->nullable(false);
            $table->string('oktmo', 11)->nullable(false);
            $table->string('postalcode', 6)->nullable(false);
            $table->datetime('startdate')->nullable(false);
            $table->datetime('enddate')->nullable(false);
            $table->datetime('updatedate')->nullable(false);
            $table->unsignedInteger('counter')->nullable(false);
            $table->unsignedInteger('divtype')->nullable(false);
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
        Schema::dropIfExists('fias_laravel_house');
    }
}
