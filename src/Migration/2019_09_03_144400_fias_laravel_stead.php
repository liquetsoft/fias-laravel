<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'Stead'.
 */
class FiasLaravelStead extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_stead'.
     */
    public function up(): void
    {
        Schema::dropIfExists('fias_laravel_stead');
        Schema::create('fias_laravel_stead', function (Blueprint $table) {
            // создание полей таблицы
            $table->uuid('steadguid')->nullable(false)->primary();
            $table->string('number', 255)->nullable(true);
            $table->string('regioncode', 2)->nullable(false);
            $table->string('postalcode', 6)->nullable(true);
            $table->string('ifnsfl', 4)->nullable(false);
            $table->string('ifnsul', 4)->nullable(false);
            $table->string('okato', 11)->nullable(false);
            $table->string('oktmo', 11)->nullable(false);
            $table->uuid('parentguid')->nullable(true);
            $table->uuid('steadid')->nullable(true);
            $table->string('operstatus', 255)->nullable(false);
            $table->datetime('startdate')->nullable(false);
            $table->datetime('enddate')->nullable(false);
            $table->datetime('updatedate')->nullable(false);
            $table->string('livestatus', 255)->nullable(false);
            $table->string('divtype', 255)->nullable(false);
            $table->uuid('normdoc')->nullable(true);
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
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
