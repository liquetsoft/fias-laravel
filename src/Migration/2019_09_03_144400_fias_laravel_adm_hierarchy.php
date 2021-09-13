<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'ADM_HIERARCHY'.
 */
class Fiaslaraveladmhierarchy extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_adm_hierarchy'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_adm_hierarchy');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_adm_hierarchy', function (Blueprint $table): void {
            // создание полей таблицы
            $table->unsignedInteger('id')->nullable(false)->comment('Уникальный идентификатор записи. Ключевое поле')->primary();
            $table->unsignedInteger('objectid')->nullable(false)->comment('Глобальный уникальный идентификатор объекта');
            $table->unsignedInteger('parentobjid')->nullable(true)->comment('Идентификатор родительского объекта');
            $table->unsignedInteger('changeid')->nullable(false)->comment('ID изменившей транзакции');
            $table->string('regioncode', 4)->nullable(true)->comment('Код региона');
            $table->string('areacode', 4)->nullable(true)->comment('Код района');
            $table->string('citycode', 4)->nullable(true)->comment('Код города');
            $table->string('placecode', 4)->nullable(true)->comment('Код населенного пункта');
            $table->string('plancode', 4)->nullable(true)->comment('Код ЭПС');
            $table->string('streetcode', 4)->nullable(true)->comment('Код улицы');
            $table->unsignedInteger('previd')->nullable(true)->comment('Идентификатор записи связывания с предыдущей исторической записью');
            $table->unsignedInteger('nextid')->nullable(true)->comment('Идентификатор записи связывания с последующей исторической записью');
            $table->datetime('updatedate')->nullable(false)->comment('Дата внесения (обновления) записи');
            $table->datetime('startdate')->nullable(false)->comment('Начало действия записи');
            $table->datetime('enddate')->nullable(false)->comment('Окончание действия записи');
            $table->unsignedInteger('isactive')->nullable(false)->comment('Признак действующего адресного объекта');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_adm_hierarchy'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_adm_hierarchy');
    }
}
