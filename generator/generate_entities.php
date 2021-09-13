<?php

declare(strict_types=1);

use Liquetsoft\Fias\Component\EntityDescriptor\BaseEntityDescriptor;
use Liquetsoft\Fias\Component\EntityField\BaseEntityField;
use Liquetsoft\Fias\Component\EntityRegistry\ArrayEntityRegistry;
use Liquetsoft\Fias\Component\EntityRegistry\PhpArrayFileRegistry;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\MigrationGenerator;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\ModelGenerator;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\ModelTestGenerator;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\ResourceGenerator;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\ResourceTestGenerator;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\SerializerGenerator;
use Marvin255\FileSystemHelper\FileSystemFactory;

$root = dirname(__DIR__);
$entitiesYaml = $root . '/vendor/liquetsoft/fias-component/resources/fias_entities.yaml';

require_once $root . '/vendor/autoload.php';

$fs = FileSystemFactory::create();
$defaultRegistry = new PhpArrayFileRegistry();
$registry = new ArrayEntityRegistry(array_merge($defaultRegistry->getDescriptors(), [
    new BaseEntityDescriptor([
        'name' => 'FIAS_VERSION',
        'description' => 'Модель, которая хранит историю версий ФИАС',
        'xmlPath' => '//',
        'fields' => [
            new BaseEntityField([
                'name' => 'version',
                'type' => 'int',
                'description' => 'Номер версии ФИАС',
                'isNullable' => false,
                'isPrimary' => true,
            ]),
            new BaseEntityField([
                'name' => 'url',
                'type' => 'string',
                'description' => 'Ссылка для загрузки указанной версии ФИАС',
                'isNullable' => false,
            ]),
            new BaseEntityField([
                'name' => 'created_at',
                'type' => 'string',
                'subType' => 'date',
                'description' => 'Дата создания записи',
                'isNullable' => false,
            ]),
        ],
    ]),
]));

$dir = $root . '/src/Entity';
$fs->mkdirIfNotExist($dir);
$fs->emptyDir($dir);
$dirObject = new SplFileInfo($dir);
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Entity';
$generator = new ModelGenerator($registry);
$generator->run($dirObject, $namespace);

$dir = $root . '/tests/Entity';
$fs->mkdirIfNotExist($dir);
$fs->emptyDir($dir);
$dirObject = new SplFileInfo($dir);
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Tests\\Entity';
$generator = new ModelTestGenerator($registry);
$generator->run($dirObject, $namespace);

$dir = $root . '/src/Migration';
$fs->mkdirIfNotExist($dir);
$fs->emptyDir($dir);
$dirObject = new SplFileInfo($dir);
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Migration';
$generator = new MigrationGenerator($registry);
$generator->run($dirObject, $namespace);

$dir = $root . '/src/Resource';
$fs->mkdirIfNotExist($dir);
$fs->emptyDir($dir);
$dirObject = new SplFileInfo($dir);
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Resource';
$generator = new ResourceGenerator($registry);
$generator->run($dirObject, $namespace);

$dir = $root . '/tests/Resource';
$fs->mkdirIfNotExist($dir);
$fs->emptyDir($dir);
$dirObject = new SplFileInfo($dir);
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Tests\\Resource';
$generator = new ResourceTestGenerator($registry);
$generator->run($dirObject, $namespace);

$dirObject = new SplFileInfo($root . '/src/Serializer');
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Serializer';
$generator = new SerializerGenerator($registry);
$generator->run($dirObject, $namespace);
