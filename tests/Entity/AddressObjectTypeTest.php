<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddressObjectType;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'AddressObjectType'.
 *
 * @internal
 */
class AddressObjectTypeTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new AddressObjectType();

        $this->assertSame('fias_laravel_address_object_type', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new AddressObjectType();
        $fields = $model->getFillable();

        $this->assertContains('kod_t_st', $fields);
        $this->assertContains('level', $fields);
        $this->assertContains('socrname', $fields);
        $this->assertContains('scname', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing(): void
    {
        $model = new AddressObjectType();

        $this->assertFalse($model->getIncrementing());
    }
}
