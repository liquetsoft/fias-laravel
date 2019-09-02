<?php

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator\ModelGenerator;
use Liquetsoft\Fias\Component\EntityRegistry\YamlEntityRegistry;

$root = dirname(__DIR__);
$entitiesYaml = $root . '/vendor/liquetsoft/fias-component/resources/fias_entities.yaml';

require_once $root . '/vendor/autoload.php';

$dir = $root . '/src/Entity';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$registry = new YamlEntityRegistry($entitiesYaml);

$dirObject = new SplFileInfo($dir);
$namespace = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Entity';
$generator = new ModelGenerator($registry);
$generator->run($dirObject, $namespace);
