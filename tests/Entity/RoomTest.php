<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Room;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'Room'.
 */
class RoomTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable()
    {
        $model = new Room();

        $this->assertSame('fias_laravel_room', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable()
    {
        $model = new Room();
        $fields = $model->getFillable();

        $this->assertContains('roomid', $fields);
        $this->assertContains('roomguid', $fields);
        $this->assertContains('houseguid', $fields);
        $this->assertContains('regioncode', $fields);
        $this->assertContains('flatnumber', $fields);
        $this->assertContains('flattype', $fields);
        $this->assertContains('postalcode', $fields);
        $this->assertContains('startdate', $fields);
        $this->assertContains('enddate', $fields);
        $this->assertContains('updatedate', $fields);
        $this->assertContains('operstatus', $fields);
        $this->assertContains('livestatus', $fields);
        $this->assertContains('normdoc', $fields);
        $this->assertContains('roomnumber', $fields);
        $this->assertContains('roomtype', $fields);
        $this->assertContains('previd', $fields);
        $this->assertContains('nextid', $fields);
        $this->assertContains('cadnum', $fields);
        $this->assertContains('roomcadnum', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing()
    {
        $model = new Room();

        $this->assertFalse($model->getIncrementing());
    }

    /**
     * Проверяет, что в модели правильно задана обработка первичного ключа.
     */
    public function testGetKeyType()
    {
        $model = new Room();

        $this->assertEquals('string', $model->getKeyType());
    }
}
