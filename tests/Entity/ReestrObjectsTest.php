<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ReestrObjects;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'ReestrObjects'.
 *
 * @internal
 */
final class ReestrObjectsTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new ReestrObjects();

        $this->assertSame('fias_laravel_reestr_objects', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new ReestrObjects();
        $fields = $model->getFillable();

        $this->assertContains('objectid', $fields);
        $this->assertContains('createdate', $fields);
        $this->assertContains('changeid', $fields);
        $this->assertContains('levelid', $fields);
        $this->assertContains('updatedate', $fields);
        $this->assertContains('objectguid', $fields);
        $this->assertContains('isactive', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing(): void
    {
        $model = new ReestrObjects();

        $this->assertFalse($model->getIncrementing());
    }
}
