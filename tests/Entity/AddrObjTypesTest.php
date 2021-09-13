<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddrObjTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'AddrObjTypes'.
 *
 * @internal
 */
class AddrObjTypesTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new AddrObjTypes();

        $this->assertSame('fias_laravel_addr_obj_types', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new AddrObjTypes();
        $fields = $model->getFillable();

        $this->assertContains('id', $fields);
        $this->assertContains('level', $fields);
        $this->assertContains('shortname', $fields);
        $this->assertContains('name', $fields);
        $this->assertContains('desc', $fields);
        $this->assertContains('updatedate', $fields);
        $this->assertContains('startdate', $fields);
        $this->assertContains('enddate', $fields);
        $this->assertContains('isactive', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing(): void
    {
        $model = new AddrObjTypes();

        $this->assertFalse($model->getIncrementing());
    }
}
