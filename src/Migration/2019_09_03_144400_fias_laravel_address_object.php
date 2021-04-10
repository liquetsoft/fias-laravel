<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Миграция для создания сущности 'AddressObject'.
 */
class FiasLaravelAddressObject extends Migration
{
    /**
     * Создание таблицы 'fias_laravel_address_object'.
     */
    public function up(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_address_object');
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->create('fias_laravel_address_object', function (Blueprint $table): void {
            // создание полей таблицы
            $table->uuid('aoid')->nullable(false)->comment('Уникальный идентификатор записи. Ключевое поле.')->primary();
            $table->uuid('aoguid')->nullable(false)->comment('Глобальный уникальный идентификатор адресного объекта');
            $table->uuid('parentguid')->nullable(true)->comment('Идентификатор объекта родительского объекта');
            $table->uuid('previd')->nullable(true)->comment('Идентификатор записи связывания с предыдушей исторической записью');
            $table->uuid('nextid')->nullable(true)->comment('Идентификатор записи  связывания с последующей исторической записью');
            $table->string('code', 17)->nullable(true)->comment('Код адресного объекта одной строкой с признаком актуальности из КЛАДР 4.0.');
            $table->string('formalname', 120)->nullable(false)->comment('Формализованное наименование');
            $table->string('offname', 120)->nullable(true)->comment('Официальное наименование');
            $table->string('shortname', 10)->nullable(false)->comment('Краткое наименование типа объекта');
            $table->unsignedInteger('aolevel')->nullable(false)->comment('Уровень адресного объекта');
            $table->string('regioncode', 2)->nullable(false)->comment('Код региона');
            $table->string('areacode', 3)->nullable(false)->comment('Код района');
            $table->string('autocode', 1)->nullable(false)->comment('Код автономии');
            $table->string('citycode', 3)->nullable(false)->comment('Код города');
            $table->string('ctarcode', 3)->nullable(false)->comment('Код внутригородского района');
            $table->string('placecode', 3)->nullable(false)->comment('Код населенного пункта');
            $table->string('plancode', 4)->nullable(false)->comment('Код элемента планировочной структуры');
            $table->string('streetcode', 4)->nullable(true)->comment('Код улицы');
            $table->string('extrcode', 4)->nullable(false)->comment('Код дополнительного адресообразующего элемента');
            $table->string('sextcode', 3)->nullable(false)->comment('Код подчиненного дополнительного адресообразующего элемента');
            $table->string('plaincode', 15)->nullable(true)->comment('Код адресного объекта из КЛАДР 4.0 одной строкой без признака актуальности (последних двух цифр)');
            $table->unsignedInteger('currstatus')->nullable(true)->comment('Статус актуальности КЛАДР 4 (последние две цифры в коде)');
            $table->unsignedInteger('actstatus')->nullable(false)->comment('Статус актуальности адресного объекта ФИАС. Актуальный адрес на текущую дату. Обычно последняя запись об адресном объекте. 0 – Не актуальный 1 - Актуальный');
            $table->unsignedInteger('livestatus')->nullable(false)->comment('Признак действующего адресного объекта');
            $table->unsignedInteger('centstatus')->nullable(false)->comment('Статус центра');
            $table->unsignedInteger('operstatus')->nullable(false)->comment('Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus): 01 – Инициация; 10 – Добавление; 20 – Изменение; 21 – Групповое изменение; 30 – Удаление; 31 - Удаление вследствие удаления вышестоящего объекта; 40 – Присоединение адресного объекта (слияние); 41 – Переподчинение вследствие слияния вышестоящего объекта; 42 - Прекращение существования вследствие присоединения к другому адресному объекту; 43 - Создание нового адресного объекта в результате слияния адресных объектов; 50 – Переподчинение; 51 – Переподчинение вследствие переподчинения вышестоящего объекта; 60 – Прекращение существования вследствие дробления; 61 – Создание нового адресного объекта в результате дробления');
            $table->string('ifnsfl', 4)->nullable(true)->comment('Код ИФНС ФЛ');
            $table->string('ifnsul', 4)->nullable(true)->comment('Код ИФНС ЮЛ');
            $table->string('terrifnsfl', 4)->nullable(true)->comment('Код территориального участка ИФНС ФЛ');
            $table->string('terrifnsul', 4)->nullable(true)->comment('Код территориального участка ИФНС ЮЛ');
            $table->string('okato', 11)->nullable(true)->comment('OKATO');
            $table->string('oktmo', 11)->nullable(true)->comment('OKTMO');
            $table->string('postalcode', 6)->nullable(true)->comment('Почтовый индекс');
            $table->datetime('startdate')->nullable(false)->comment('Начало действия записи');
            $table->datetime('enddate')->nullable(false)->comment('Окончание действия записи');
            $table->datetime('updatedate')->nullable(false)->comment('Дата  внесения записи');
            $table->unsignedInteger('divtype')->nullable(false)->comment('Тип адресации:                   0 - не определено                   1 - муниципальный;                   2 - административно-территориальный');
            $table->uuid('normdoc')->nullable(true)->comment('Внешний ключ на нормативный документ');
            // создание индексов таблицы
            $table->index('aoguid');
            // настройки таблицы
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Удаление таблицы 'fias_laravel_address_object'.
     */
    public function down(): void
    {
        Schema::connection(config('liquetsoft_fias.eloquent_connection'))->dropIfExists('fias_laravel_address_object');
    }
}
