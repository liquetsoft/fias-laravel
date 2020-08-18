<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\EstateStatus;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'EstateStatus'.
 */
class EstateStatusTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable()
    {
        $model = new EstateStatus();

        $this->assertSame('fias_laravel_estate_status', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable()
    {
        $model = new EstateStatus();
        $fields = $model->getFillable();

        $this->assertContains('eststatid', $fields);
        $this->assertContains('name', $fields);
        $this->assertContains('shortname', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing()
    {
        $model = new EstateStatus();

        $this->assertFalse($model->getIncrementing());
    }
}
