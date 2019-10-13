<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FiasVersion;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'FiasVersion'.
 */
class FiasVersionTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable()
    {
        $model = new FiasVersion();

        $this->assertSame('fias_laravel_fias_version', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable()
    {
        $model = new FiasVersion();
        $fields = $model->getFillable();

        $this->assertContains('version', $fields);
        $this->assertContains('url', $fields);
        $this->assertContains('created_at', $fields);
        $this->assertContains('updated_at', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing()
    {
        $model = new FiasVersion();

        $this->assertFalse($model->getIncrementing());
    }
}
