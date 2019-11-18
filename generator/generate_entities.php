<?php

use Liquetsoft\Fias\Component\EntityDescriptor\BaseEntityDescriptor;
use Liquetsoft\Fias\Component\EntityField\BaseEntityField;
use Liquetsoft\Fias\Component\EntityRegistry\ArrayEntityRegistry;
use Liquetsoft\Fias\Component\EntityRegistry\YamlEntityRegistry;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\MigrationGenerator;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\ModelGenerator;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\ModelTestGenerator;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\ResourceGenerator;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\ResourceTestGenerator;

$root = dirname(__DIR__);
$entitiesYaml = $root . '/vendor/liquetsoft/fias-component/resources/fias_entities.yaml';

require_once $root . '/vendor/autoload.php';

$yamlRegistry = new YamlEntityRegistry($entitiesYaml);
$registry = new ArrayEntityRegistry(array_merge($yamlRegistry->getDescriptors(), [
    new BaseEntityDescriptor([
        'name' => 'FiasVersion',
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
                'type' => 'date',
                'description' => 'Дата создания записи',
                'isNullable' => false,
            ]),
        ],
    ]),
]));

$dir = $root . '/src/Entity';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}
$dirObject = new SplFileInfo($dir);
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Entity';
$generator = new ModelGenerator($registry);
$generator->run($dirObject, $namespace);

$dir = $root . '/tests/Entity';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}
$dirObject = new SplFileInfo($dir);
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Tests\\Entity';
$generator = new ModelTestGenerator($registry);
$generator->run($dirObject, $namespace);

$dir = $root . '/src/Migration';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}
$dirObject = new SplFileInfo($dir);
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Migration';
$generator = new MigrationGenerator($registry);
$generator->run($dirObject, $namespace);

$dir = $root . '/src/Resource';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}
$dirObject = new SplFileInfo($dir);
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Resource';
$generator = new ResourceGenerator($registry);
$generator->run($dirObject, $namespace);

$dir = $root . '/tests/Resource';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}
$dirObject = new SplFileInfo($dir);
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Tests\\Resource';
$generator = new ResourceTestGenerator($registry);
$generator->run($dirObject, $namespace);
