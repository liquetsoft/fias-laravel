# fias-laravel

[![Latest Stable Version](https://poser.pugx.org/liquetsoft/fias-laravel/v/stable.png)](https://packagist.org/packages/liquetsoft/fias-laravel)
[![Total Downloads](https://poser.pugx.org/liquetsoft/fias-laravel/downloads.png)](https://packagist.org/packages/liquetsoft/fias-laravel)
[![License](https://poser.pugx.org/liquetsoft/fias-laravel/license.svg)](https://packagist.org/packages/liquetsoft/fias-laravel)
[![Build Status](https://travis-ci.org/liquetsoft/fias-laravel.svg?branch=master)](https://travis-ci.org/liquetsoft/fias-laravel)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/liquetsoft/fias-laravel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/liquetsoft/fias-laravel/?branch=master)

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

4. Бандл предоставляет миграции, которые создадут структуру таблиц в базе данных:

    ```bash
    php artisan migrate
    ```

   Миграции можно отключить с помощью опции `allow_bundle_migrations`, в случае если структура не подходит или является избыточной:

    ```php
    // config/liquetsoft_fias.php
    'allow_bundle_migrations' => false,
    ```

5. Бандл пытается конвертировать записи ФИАС в объекты. Необходимо указать какие именно сущности используются (те сущности, для которых не указан класс конвертации использоваться не будут) и в какие объекты конвертируются (важно понимать, что сущность на стороне проекта может быть любой, [сериализатор symfony](https://symfony.com/doc/current/components/serializer.html) попробует преобразовать xml в указанный объект):

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
        'ActualStatus' => ActualStatus::class,
        'AddressObject' => AddressObject::class,
        'AddressObjectType' => AddressObjectType::class,
        'CenterStatus' => CenterStatus::class,
        'CurrentStatus' => CurrentStatus::class,
        'EstateStatus' => EstateStatus::class,
        'FlatType' => FlatType::class,
        'House' => House::class,
        'HouseStateStatus' => HouseStateStatus::class,
        'IntervalStatus' => IntervalStatus::class,
        'NormativeDocument' => NormativeDocument::class,
        'NormativeDocumentType' => NormativeDocumentType::class,
        'OperationStatus' => OperationStatus::class,
        'Room' => Room::class,
        'RoomType' => RoomType::class,
        'Stead' => Stead::class,
        'StructureStatus' => StructureStatus::class,
    ],
    ```

    В составе бандла поставляются так же соответствующие eloquent-модели и ресурсные классы:

    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ActualStatus`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddressObject`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddressObjectType`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\CenterStatus`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\CurrentStatus`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\EstateStatus`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FlatType`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\House`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\HouseStateStatus`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\IntervalStatus`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocument`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocumentType`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\OperationStatus`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Room`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\RoomType`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Stead`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\StructureStatus`,
    * `Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FiasVersion`.

Для примера, все шаги установки проделаны в [тестовом проекте](https://github.com/liquetsoft/fias-laravel-example).



Использование
-------------

Бандл определяет две значимых команды консоли:

1. Установка ФИАС с ноля

    ```bash
    php artisan liquetsoft:fias:install
    ```

2. Обновление ФИАС через дельту

    ```bash
    php artisan liquetsoft:fias:update
    ```

Соответственно, установка запускается только в первый раз, а обновление следует поставить в качестве задачи для `cron`.



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
