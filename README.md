# fias-laravel

[![Latest Stable Version](https://poser.pugx.org/liquetsoft/fias-laravel/v/stable.png)](https://packagist.org/packages/liquetsoft/fias-laravel)
[![Total Downloads](https://poser.pugx.org/liquetsoft/fias-laravel/downloads.png)](https://packagist.org/packages/liquetsoft/fias-laravel)
[![License](https://poser.pugx.org/liquetsoft/fias-laravel/license.svg)](https://packagist.org/packages/liquetsoft/fias-laravel)
[![Build Status](https://github.com/liquetsoft/fias-laravel/workflows/liquetsoft_fias/badge.svg)](https://github.com/liquetsoft/fias-laravel/actions?query=workflow%3A%22liquetsoft_fias%22)

Бандл laravel для установки данных из [ФИАС](https://fias.nalog.ru/).

Для установки ФИАС используются xml-файлы, ссылки на которые предоставляются SOAP-сервисом информирования ФИАС.



Установка
---------
1. Установить пакет с помощью composer:

    ```bash
    composer require liquetsoft/fias-laravel
    ```

2. Бандл следует стандартной структуре, поэтому на `laravel >=5.5` зарегистрируется автоматически с помощью `Package Discovery`. Для более ранних версий провайдер нужно зарегистрировать самостоятельно, добавив его в `config/app.php`:

    ```php
    'providers' => [
        // Other Service Providers
        Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\LiquetsoftFiasBundleServiceProvider::class,
    ],
    ```

3. Бандл предоставляет свою конфигурацию и по умолчанию будет использовать именно её. Настоятельно рекомендуется опубликовать копию конфигурации в проект, а не использовать встроенную:

    ```bash
    php artisan vendor:publish --provider="Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\LiquetsoftFiasBundleServiceProvider"
    ```

4. Можно настроить подключение к бд, которое будет использовать бандл, с помощью опции `eloquent_connection`:

    ```php
    // config/liquetsoft_fias.php
    'eloquent_connection' => 'custom_connection',
    ```

5. Бандл предоставляет миграции, которые создадут структуру таблиц в базе данных:

    ```bash
    php artisan migrate
    ```

   Миграции можно отключить с помощью опции `allow_bundle_migrations`, в случае если структура не подходит или является избыточной:

    ```php
    // config/liquetsoft_fias.php
    'allow_bundle_migrations' => false,
    ```

6. Бандл пытается конвертировать записи ФИАС в объекты. Необходимо указать какие именно сущности используются (те сущности, для которых не указан класс конвертации использоваться не будут) и в какие объекты конвертируются (важно понимать, что сущность на стороне проекта может быть любой, [сериализатор symfony](https://symfony.com/doc/current/components/serializer.html) попробует преобразовать xml в указанный объект):

    ```php
    // config/liquetsoft_fias.php
    /*
     * Имя класса для сущности, которая хранит историю версий ФИАС.
     */
    'version_manager_entity' => FiasVersion::class,
    /*
     * Связка между сущностями ФИАС и моделями в проекте.
     */
    'entity_bindings' => [
        'ADDR_OBJ' => AddrObj::class,
        'ADDR_OBJ_DIVISION' => AddrObjDivision::class,
        'ADDR_OBJ_TYPES' => AddrObjTypes::class,
        'ADM_HIERARCHY' => AdmHierarchy::class,
        'APARTMENTS' => Apartments::class,
        'APARTMENT_TYPES' => ApartmentTypes::class,
        'CARPLACES' => Carplaces::class,
        'CHANGE_HISTORY' => ChangeHistory::class,
        'FIAS_VERSION' => FiasVersion::class,
        'HOUSES' => Houses::class,
        'HOUSE_TYPES' => HouseTypes::class,
        'MUN_HIERARCHY' => MunHierarchy::class,
        'NORMATIVE_DOCS' => NormativeDocs::class,
        'NORMATIVE_DOCS_KINDS' => NormativeDocsKinds::class,
        'NORMATIVE_DOCS_TYPES' => NormativeDocsTypes::class,
        'OBJECT_LEVELS' => ObjectLevels::class,
        'OPERATION_TYPES' => OperationTypes::class,
        'PARAM' => Param::class,
        'PARAM_TYPES' => ParamTypes::class,
        'REESTR_OBJECTS' => ReestrObjects::class,
        'ROOMS' => Rooms::class,
        'ROOM_TYPES' => RoomTypes::class,
        'STEADS' => Steads::class,
    ],
    ```

    В составе бандла поставляются так же соответствующие eloquent-модели и ресурсные классы:

    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddrObj`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddrObjDivision`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddrObjTypes`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AdmHierarchy`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Apartments`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ApartmentTypes`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Carplaces`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ChangeHistory`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FiasVersion`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Houses`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\HouseTypes`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\MunHierarchy`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocs`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocsKinds`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocsTypes`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ObjectLevels`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\OperationTypes`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Param`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ParamTypes`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ReestrObjects`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Rooms`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\RoomTypes`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Steads`.



Использование
-------------

Бандл предоставляет несколько значимых команды консоли:

1. Установка ФИАС с ноля

    ```bash
    php artisan liquetsoft:fias:install
    ```

2. Обновление ФИАС через дельту (установка запускается только в первый раз, а обновление следует поставить в качестве задачи для `cron`)

    ```bash
    php artisan liquetsoft:fias:update
    ```

3. Текущий статус серверов ФИАС (сервис информирования или сервер с файлами могут быть недоступны по тем или иным причинам)

    ```bash
    php artisan liquetsoft:fias:status
    ```

4. Список доступных для установки и обновления версий ФИАС

    ```bash
    php artisan liquetsoft:fias:versions
    ```

5. Загрузка и распаковка архива с полной версией ФИАС

    ```bash
    php artisan liquetsoft:fias:download /path/to/download full --extract
    ```

6. Установка ФИАС из указанного каталога

    ```bash
    php artisan liquetsoft:fias:install_from_folder /path/to/extracted/fias
    ```

7. Обновление ФИАС из указанного каталога

    ```bash
    php artisan liquetsoft:fias:update_from_folder /path/to/extracted/fias
    ```

8. Принудительная установка номера текущей версии ФИАС

    ```bash
    php artisan liquetsoft:fias:version_set 20160101
    ```



Производительность
------------------

Есть несколько возможностей ускорить импорт, используя настройки бандла:

1. убрать неиспользуемые сущности; к примеру, если информация о парковочных местах не требуется, то можно отключить соответствие для `CARPLACES`

    ```php
    // liquetsoft_fias.php
    'entity_bindings' => [
        // 'CARPLACES' => Carplaces::class,
    ],
    ```

2. поскольку в формате ГАР все данные разделены по папкам регионов, то можно исключить обработку файлов для неиспользуемых регионов

    ```php
    // liquetsoft_fias.php
    'files_filter' => [
        "#^.+/extracted/30/AS_.+$#", // разрешает все данные для региона
        "#^.+/extracted/AS_.+$#",    // разрешает общие словари
        // все остальные файлы будут проигнорированы
    ],
    ```



Allowed Memory Size Exhausted
-----------------------------

В некоторых установках laravel во время установки ФИАС возникает ошибка из-за недостатка оперативной памяти для скрипта. Это связано с пакетами для дебага и логирования. Для установки ФИАС следует либо отключать эти пакеты совсем, либо отключать обработку запросов к базе данных.

Известные конфликты:

1. **facade/ignition**:

    * опубликуйте конфигурационный файл, если он еще не опубликован, с помощью команды:

        ```bash
        php artisan vendor:publish --provider="Facade\Ignition\IgnitionServiceProvider" --tag="flare-config"
        ```

    * отключите логирование запросов к базе данных:

        ```php
        //в config/flare.php
        'reporting' => [
            'report_queries' => false,
            'report_query_bindings' => false,
        ],
        ```
