<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Базовый класс для всех тестов.
 */
abstract class BaseCase extends TestCase
{
    /**
     * @var \Faker\Generator|null
     */
    private $faker;

    /**
     * Возвращает объект php faker для генерации случайных данных.
     *
     * Использует ленивую инициализацию и создает объект faker только при первом
     * запросе, для всех последующих запросов возвращает тот же самый инстанс,
     * который был создан в первый раз.
     *
     * @return \Faker\Generator
     */
    public function createFakeData(): \Faker\Generator
    {
        if ($this->faker === null) {
            $this->faker = \Faker\Factory::create();
        }

        return $this->faker;
    }
}