<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Apartments;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'Apartments'.
 *
 * @internal
 */
class ApartmentsTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new Apartments();

        $this->assertSame('fias_laravel_apartments', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new Apartments();
        $fields = $model->getFillable();

        $this->assertContains('id', $fields);
        $this->assertContains('objectid', $fields);
        $this->assertContains('objectguid', $fields);
        $this->assertContains('changeid', $fields);
        $this->assertContains('number', $fields);
        $this->assertContains('aparttype', $fields);
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
        $model = new Apartments();

        $this->assertFalse($model->getIncrementing());
    }
}
