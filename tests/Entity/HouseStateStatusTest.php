<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\HouseStateStatus;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'HouseStateStatus'.
 */
class HouseStateStatusTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable()
    {
        $model = new HouseStateStatus();

        $this->assertSame('fias_laravel_house_state_status', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable()
    {
        $model = new HouseStateStatus();
        $fields = $model->getFillable();

        $this->assertContains('housestid', $fields);
        $this->assertContains('name', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing()
    {
        $model = new HouseStateStatus();

        $this->assertFalse($model->getIncrementing());
    }
}
