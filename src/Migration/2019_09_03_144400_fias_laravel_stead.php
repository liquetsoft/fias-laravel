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
            $table->uuid('steadguid')->nullable(false)->comment('Глобальный уникальный идентификатор адресного объекта (земельного участка)');
            $table->string('number', 120)->nullable(true)->comment('Номер земельного участка');
            $table->string('regioncode', 2)->nullable(false)->comment('Код региона');
            $table->string('postalcode', 6)->nullable(true)->comment('Почтовый индекс');
            $table->string('ifnsfl', 4)->nullable(true)->comment('Код ИФНС ФЛ');
            $table->string('ifnsul', 4)->nullable(true)->comment('Код ИФНС ЮЛ');
            $table->string('okato', 11)->nullable(true)->comment('OKATO');
            $table->string('oktmo', 11)->nullable(true)->comment('OKTMO');
            $table->uuid('parentguid')->nullable(true)->comment('Идентификатор объекта родительского объекта');
            $table->uuid('steadid')->nullable(false)->comment('Уникальный идентификатор записи. Ключевое поле.')->primary();
            $table->unsignedInteger('operstatus')->nullable(false)->comment('Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus): 01 – Инициация; 10 – Добавление; 20 – Изменение; 21 – Групповое изменение; 30 – Удаление; 31 - Удаление вследствие удаления вышестоящего объекта; 40 – Присоединение адресного объекта (слияние); 41 – Переподчинение вследствие слияния вышестоящего объекта; 42 - Прекращение существования вследствие присоединения к другому адресному объекту; 43 - Создание нового адресного объекта в результате слияния адресных объектов; 50 – Переподчинение; 51 – Переподчинение вследствие переподчинения вышестоящего объекта; 60 – Прекращение существования вследствие дробления; 61 – Создание нового адресного объекта в результате дробления');
            $table->datetime('startdate')->nullable(false)->comment('Начало действия записи');
            $table->datetime('enddate')->nullable(false)->comment('Окончание действия записи');
            $table->datetime('updatedate')->nullable(false)->comment('Дата  внесения записи');
            $table->unsignedInteger('livestatus')->nullable(false)->comment('Признак действующего адресного объекта');
            $table->unsignedInteger('divtype')->nullable(false)->comment('Тип адресации: 0 - не определено 1 - муниципальный; 2 - административно-территориальный');
            $table->uuid('normdoc')->nullable(true)->comment('Внешний ключ на нормативный документ');
            $table->string('terrifnsfl', 4)->nullable(true)->comment('Код территориального участка ИФНС ФЛ');
            $table->string('terrifnsul', 4)->nullable(true)->comment('Код территориального участка ИФНС ЮЛ');
            $table->uuid('previd')->nullable(true)->comment('Идентификатор записи связывания с предыдушей исторической записью');
            $table->uuid('nextid')->nullable(true)->comment('Идентификатор записи  связывания с последующей исторической записью');
            $table->string('cadnum', 100)->nullable(true)->comment('Кадастровый номер');
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
