<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddressObject;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'AddressObject'.
 */
class AddressObjectTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable()
    {
        $model = new AddressObject();

        $this->assertSame('fias_laravel_address_object', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable()
    {
        $model = new AddressObject();
        $fields = $model->getFillable();

        $this->assertContains('aoid', $fields);
        $this->assertContains('aoguid', $fields);
        $this->assertContains('parentguid', $fields);
        $this->assertContains('previd', $fields);
        $this->assertContains('nextid', $fields);
        $this->assertContains('code', $fields);
        $this->assertContains('formalname', $fields);
        $this->assertContains('offname', $fields);
        $this->assertContains('shortname', $fields);
        $this->assertContains('aolevel', $fields);
        $this->assertContains('regioncode', $fields);
        $this->assertContains('areacode', $fields);
        $this->assertContains('autocode', $fields);
        $this->assertContains('citycode', $fields);
        $this->assertContains('ctarcode', $fields);
        $this->assertContains('placecode', $fields);
        $this->assertContains('plancode', $fields);
        $this->assertContains('streetcode', $fields);
        $this->assertContains('extrcode', $fields);
        $this->assertContains('sextcode', $fields);
        $this->assertContains('plaincode', $fields);
        $this->assertContains('currstatus', $fields);
        $this->assertContains('actstatus', $fields);
        $this->assertContains('livestatus', $fields);
        $this->assertContains('centstatus', $fields);
        $this->assertContains('operstatus', $fields);
        $this->assertContains('ifnsfl', $fields);
        $this->assertContains('ifnsul', $fields);
        $this->assertContains('terrifnsfl', $fields);
        $this->assertContains('terrifnsul', $fields);
        $this->assertContains('okato', $fields);
        $this->assertContains('oktmo', $fields);
        $this->assertContains('postalcode', $fields);
        $this->assertContains('startdate', $fields);
        $this->assertContains('enddate', $fields);
        $this->assertContains('updatedate', $fields);
        $this->assertContains('divtype', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing()
    {
        $model = new AddressObject();

        $this->assertFalse($model->getIncrementing());
    }

    /**
     * Проверяет, что в модели правильно задана обработка первичного ключа.
     */
    public function testGetKeyType()
    {
        $model = new AddressObject();

        $this->assertEquals('string', $model->getKeyType());
    }
}
