<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'House'.
 */
class House20190903144400 extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_house'.
     */
    public function up(): void
    {
        Schema::create('fias_laravel_house', function (Blueprint $table) {
            // создание полей таблицы
            $table->string('houseid', 255)->nullable(false);
            $table->string('houseguid', 255);
            $table->string('aoguid', 255);
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
            // создание индексов таблицы
            $table->primary('houseid');
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_house'.
     */
    public function down(): void
    {
        Schema::dropIfExists('fias_laravel_house');
    }
}
