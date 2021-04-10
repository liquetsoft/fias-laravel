<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FlatType;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'FlatType'.
 *
 * @internal
 */
class FlatTypeTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new FlatType();

        $this->assertSame('fias_laravel_flat_type', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new FlatType();
        $fields = $model->getFillable();

        $this->assertContains('fltypeid', $fields);
        $this->assertContains('name', $fields);
        $this->assertContains('shortname', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing(): void
    {
        $model = new FlatType();

        $this->assertFalse($model->getIncrementing());
    }
}
