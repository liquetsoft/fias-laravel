<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Stead;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'Stead'.
 */
class SteadTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable()
    {
        $model = new Stead();

        $this->assertSame('fias_laravel_stead', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable()
    {
        $model = new Stead();
        $fields = $model->getFillable();

        $this->assertContains('steadguid', $fields);
        $this->assertContains('number', $fields);
        $this->assertContains('regioncode', $fields);
        $this->assertContains('postalcode', $fields);
        $this->assertContains('ifnsfl', $fields);
        $this->assertContains('ifnsul', $fields);
        $this->assertContains('okato', $fields);
        $this->assertContains('oktmo', $fields);
        $this->assertContains('parentguid', $fields);
        $this->assertContains('steadid', $fields);
        $this->assertContains('operstatus', $fields);
        $this->assertContains('startdate', $fields);
        $this->assertContains('enddate', $fields);
        $this->assertContains('updatedate', $fields);
        $this->assertContains('livestatus', $fields);
        $this->assertContains('divtype', $fields);
        $this->assertContains('normdoc', $fields);
        $this->assertContains('terrifnsfl', $fields);
        $this->assertContains('terrifnsul', $fields);
        $this->assertContains('previd', $fields);
        $this->assertContains('nextid', $fields);
        $this->assertContains('cadnum', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing()
    {
        $model = new Stead();

        $this->assertFalse($model->getIncrementing());
    }

    /**
     * Проверяет, что в модели правильно задана обработка первичного ключа.
     */
    public function testGetKeyType()
    {
        $model = new Stead();

        $this->assertEquals('string', $model->getKeyType());
    }
}
