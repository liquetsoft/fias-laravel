<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'Stead'.
 */
class Stead20190903144400 extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_stead'.
     */
    public function up(): void
    {
        Schema::create('fias_laravel_stead', function (Blueprint $table) {
            // создание полей таблицы
            $table->string('steadguid', 255)->nullable(false);
            $table->string('number', 255)->nullable(false);
            $table->string('regioncode', 2)->nullable(false);
            $table->string('postalcode', 6)->nullable(false);
            $table->string('ifnsfl', 4)->nullable(false);
            $table->string('ifnsul', 4)->nullable(false);
            $table->string('okato', 11)->nullable(false);
            $table->string('oktmo', 11)->nullable(false);
            $table->string('parentguid', 255);
            $table->string('steadid', 255);
            $table->string('operstatus', 255)->nullable(false);
            $table->datetime('startdate')->nullable(false);
            $table->datetime('enddate')->nullable(false);
            $table->datetime('updatedate')->nullable(false);
            $table->string('livestatus', 255)->nullable(false);
            $table->string('divtype', 255)->nullable(false);
            $table->string('normdoc', 255);
            // создание индексов таблицы
            $table->primary('steadguid');
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_stead'.
     */
    public function down(): void
    {
        Schema::dropIfExists('fias_laravel_stead');
    }
}
