<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\MunHierarchy;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'MunHierarchy'.
 *
 * @internal
 */
class MunHierarchyTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new MunHierarchy();

        $this->assertSame('fias_laravel_mun_hierarchy', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new MunHierarchy();
        $fields = $model->getFillable();

        $this->assertContains('id', $fields);
        $this->assertContains('objectid', $fields);
        $this->assertContains('parentobjid', $fields);
        $this->assertContains('changeid', $fields);
        $this->assertContains('oktmo', $fields);
        $this->assertContains('previd', $fields);
        $this->assertContains('nextid', $fields);
        $this->assertContains('updatedate', $fields);
        $this->assertContains('startdate', $fields);
        $this->assertContains('enddate', $fields);
        $this->assertContains('isactive', $fields);
        $this->assertContains('path', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing(): void
    {
        $model = new MunHierarchy();

        $this->assertFalse($model->getIncrementing());
    }
}
