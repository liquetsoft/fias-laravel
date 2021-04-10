<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\House;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'House'.
 *
 * @internal
 */
class HouseTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new House();

        $this->assertSame('fias_laravel_house', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new House();
        $fields = $model->getFillable();

        $this->assertContains('houseid', $fields);
        $this->assertContains('houseguid', $fields);
        $this->assertContains('aoguid', $fields);
        $this->assertContains('housenum', $fields);
        $this->assertContains('strstatus', $fields);
        $this->assertContains('eststatus', $fields);
        $this->assertContains('statstatus', $fields);
        $this->assertContains('ifnsfl', $fields);
        $this->assertContains('ifnsul', $fields);
        $this->assertContains('okato', $fields);
        $this->assertContains('oktmo', $fields);
        $this->assertContains('postalcode', $fields);
        $this->assertContains('startdate', $fields);
        $this->assertContains('enddate', $fields);
        $this->assertContains('updatedate', $fields);
        $this->assertContains('counter', $fields);
        $this->assertContains('divtype', $fields);
        $this->assertContains('regioncode', $fields);
        $this->assertContains('terrifnsfl', $fields);
        $this->assertContains('terrifnsul', $fields);
        $this->assertContains('buildnum', $fields);
        $this->assertContains('strucnum', $fields);
        $this->assertContains('normdoc', $fields);
        $this->assertContains('cadnum', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing(): void
    {
        $model = new House();

        $this->assertFalse($model->getIncrementing());
    }

    /**
     * Проверяет, что в модели правильно задана обработка первичного ключа.
     */
    public function testGetKeyType(): void
    {
        $model = new House();

        $this->assertSame('string', $model->getKeyType());
    }
}
