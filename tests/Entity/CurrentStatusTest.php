<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\CurrentStatus;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'CurrentStatus'.
 *
 * @internal
 */
class CurrentStatusTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new CurrentStatus();

        $this->assertSame('fias_laravel_current_status', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new CurrentStatus();
        $fields = $model->getFillable();

        $this->assertContains('curentstid', $fields);
        $this->assertContains('name', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing(): void
    {
        $model = new CurrentStatus();

        $this->assertFalse($model->getIncrementing());
    }
}
