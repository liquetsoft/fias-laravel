<?php

declare(strict_types=1);

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddrObj;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddrObjDivision;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddrObjTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AdmHierarchy;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Apartments;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ApartmentTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Carplaces;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ChangeHistory;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FiasVersion;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Houses;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\HouseTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\MunHierarchy;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocs;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocsKinds;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocsTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ObjectLevels;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\OperationTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Param;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ParamTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ReestrObjects;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Rooms;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\RoomTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Steads;

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
        'ADDR_OBJ' => AddrObj::class,
        'ADDR_OBJ_DIVISION' => AddrObjDivision::class,
        'ADDR_OBJ_TYPES' => AddrObjTypes::class,
        'ADM_HIERARCHY' => AdmHierarchy::class,
        'APARTMENTS' => Apartments::class,
        'APARTMENT_TYPES' => ApartmentTypes::class,
        'CARPLACES' => Carplaces::class,
        'CHANGE_HISTORY' => ChangeHistory::class,
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
    /*
     * Путь для запуска artisan.
     */
    'path_to_bin' => base_path('artisan'),
    /*
     * Имя команды для запуска параллельных процессов установки.
     */
    'command_name_install' => 'liquetsoft:fias:install_parallel_running',
    /*
     * Имя команды для запуска параллельных процессов обновления.
     */
    'command_name_update' => 'liquetsoft:fias:update_parallel_running',
    /*
     * Максимальное число параллельных процессов установки.
     */
    'number_of_parallel' => 10,
    /*
     * Максимальное число ошибок во время загрузки файлов, после которого она будет прекращена.
     */
    'download_retry_attempts' => 10,
    /*
     * Фильтры для выбора файлов. Заются в формате регулярного выражения, например #^.+/extracted/30/AS_.+$#
     */
    'files_filter' => [],
];
