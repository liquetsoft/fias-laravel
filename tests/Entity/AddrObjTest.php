<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddrObj;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'AddrObj'.
 *
 * @internal
 */
final class AddrObjTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new AddrObj();

        $this->assertSame('fias_laravel_addr_obj', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new AddrObj();
        $fields = $model->getFillable();

        $this->assertContains('id', $fields);
        $this->assertContains('objectid', $fields);
        $this->assertContains('objectguid', $fields);
        $this->assertContains('changeid', $fields);
        $this->assertContains('name', $fields);
        $this->assertContains('typename', $fields);
        $this->assertContains('level', $fields);
        $this->assertContains('opertypeid', $fields);
        $this->assertContains('previd', $fields);
        $this->assertContains('nextid', $fields);
        $this->assertContains('updatedate', $fields);
        $this->assertContains('startdate', $fields);
        $this->assertContains('enddate', $fields);
        $this->assertContains('isactual', $fields);
        $this->assertContains('isactive', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing(): void
    {
        $model = new AddrObj();

        $this->assertFalse($model->getIncrementing());
    }
}
