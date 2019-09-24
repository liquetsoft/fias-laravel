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
        Schema::create('fias_laravel_room', function (Blueprint $table) {
            // создание полей таблицы
            $table->uuid('roomid')->nullable(false)->primary();
            $table->uuid('roomguid');
            $table->uuid('houseguid');
            $table->string('regioncode', 2)->nullable(false);
            $table->string('flatnumber', 50)->nullable(false);
            $table->unsignedInteger('flattype')->nullable(false);
            $table->string('postalcode', 6)->nullable(false);
            $table->datetime('startdate')->nullable(false);
            $table->datetime('enddate')->nullable(false);
            $table->datetime('updatedate')->nullable(false);
            $table->string('operstatus', 255)->nullable(false);
            $table->string('livestatus', 255)->nullable(false);
            $table->uuid('normdoc');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });

        //для mysql большие таблицы нужно разбивать на части
        $connection = DB::connection();
        if ($connection instanceof Connection && $connection->getDriverName() === 'mysql') {
            //разбиваем таблицу на части
            DB::connection()->unprepared('ALTER TABLE fias_laravel_room PARTITION BY KEY() PARTITIONS 4;');
        }
    }

    /**
     * Удаление таблицы 'fias_laravel_room'.
     */
    public function down(): void
    {
        Schema::dropIfExists('fias_laravel_room');
    }
}
