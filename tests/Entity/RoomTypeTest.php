<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\RoomType;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'RoomType'.
 */
class RoomTypeTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable()
    {
        $model = new RoomType();

        $this->assertSame('fias_laravel_room_type', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable()
    {
        $model = new RoomType();
        $fields = $model->getFillable();

        $this->assertContains('rmtypeid', $fields);
        $this->assertContains('name', $fields);
        $this->assertContains('shortname', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing()
    {
        $model = new RoomType();

        $this->assertFalse($model->getIncrementing());
    }
}
