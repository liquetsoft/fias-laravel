<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddrObjDivision;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'AddrObjDivision'.
 *
 * @internal
 */
final class AddrObjDivisionTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new AddrObjDivision();

        $this->assertSame('fias_laravel_addr_obj_division', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new AddrObjDivision();
        $fields = $model->getFillable();

        $this->assertContains('id', $fields);
        $this->assertContains('parentid', $fields);
        $this->assertContains('childid', $fields);
        $this->assertContains('changeid', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing(): void
    {
        $model = new AddrObjDivision();

        $this->assertFalse($model->getIncrementing());
    }
}
