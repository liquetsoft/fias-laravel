<?php

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\ModelGenerator;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\MigrationGenerator;
use Liquetsoft\Fias\Component\EntityRegistry\YamlEntityRegistry;

$root = dirname(__DIR__);
$entitiesYaml = $root . '/vendor/liquetsoft/fias-component/resources/fias_entities.yaml';

require_once $root . '/vendor/autoload.php';

$registry = new YamlEntityRegistry($entitiesYaml);

$dir = $root . '/src/Entity';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}
$dirObject = new SplFileInfo($dir);
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Entity';
$generator = new ModelGenerator($registry);
$generator->run($dirObject, $namespace);

$dir = $root . '/src/Migration';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}
$dirObject = new SplFileInfo($dir);
$currentState = new SplFileInfo(__DIR__ . '/current_state.yaml');
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Migration';
$generator = new MigrationGenerator($registry, $currentState);
$generator->run($dirObject, $namespace);
