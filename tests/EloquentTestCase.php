<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests;

use Illuminate\Database\Capsule\Manager;

/**
 * Базовый класс для всех тестов, которые используют базу данных.
 */
abstract class EloquentTestCase extends BaseCase
{
    /**
     * Sets up eloquent connection.
     */
    protected function setUp(): void
    {
        $capsule = new Manager();

        $capsule->addConnection(
            [
                'driver' => getenv('DB_DRIVER'),
                'host' => getenv('DB_HOST'),
                'username' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
                'database' => getenv('DB_NAME'),
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ]
        );
    }
}
