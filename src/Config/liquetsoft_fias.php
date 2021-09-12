<?php

declare(strict_types=1);

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ActualStatus;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddressObject;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddressObjectType;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\CenterStatus;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\CurrentStatus;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\EstateStatus;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FiasVersion;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FlatType;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\House;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocument;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocumentType;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\OperationStatus;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Room;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\RoomType;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Stead;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\StructureStatus;

return [
    /*
     * Исрользовать или нет миграции из состава бандла.
     */
    'allow_bundle_migrations' => true,
    /*
     * Ссылка на WSDL сервиса, который возвращает ссылки на архив с ФИАС для указанных версий.
     */
    'informer_wsdl' => 'http://fias.nalog.ru/WebServices/Public/DownloadService.asmx?WSDL',
    /*
     * Путь к yaml файлу с описаниями сущностей ФИАС. null - использовать по умолчанию.
     */
    'registry_path' => null,
    /*
     * Путь к папке со временными файлами для процесса загрузки.
     */
    'temp_dir' => storage_path('liquetsoft_fias'),
    /*
     * Имя класса для сущности, которая хранит историю версий ФИАС.
     */
    'version_manager_entity' => FiasVersion::class,
    /*
     * Количество записей для вставки с помошью bulk insert.
     */
    'insert_batch_count' => 800,
    /*
     * Подключение к базе данных, которое следует использовать для ФИАС. null - использовать по умолчанию.
     */
    'eloquent_connection' => null,
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
        'NormativeDocument' => NormativeDocument::class,
        'NormativeDocumentType' => NormativeDocumentType::class,
        'OperationStatus' => OperationStatus::class,
        'Room' => Room::class,
        'RoomType' => RoomType::class,
        'Stead' => Stead::class,
        'StructureStatus' => StructureStatus::class,
    ],
    /*
     * Путь для запуска artisan.
     */
    'path_to_bin' => base_path('artisan'),
    /*
     * Имя команды для запуска параллельных процессов установки.
     */
    'command_name' => 'liquetsoft:fias:install_parallel_running',
    /*
     * Максимальное число параллельных процессов установки.
     */
    'number_of_parallel' => 5,
    /*
     * Максимальное число ошибок во время загрузки файлов, после которого она будет прекращена.
     */
    'download_retry_attempts' => 10,
];
