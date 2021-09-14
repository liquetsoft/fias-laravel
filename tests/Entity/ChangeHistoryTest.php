<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ChangeHistory;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'ChangeHistory'.
 *
 * @internal
 */
class ChangeHistoryTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new ChangeHistory();

        $this->assertSame('fias_laravel_change_history', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new ChangeHistory();
        $fields = $model->getFillable();

        $this->assertContains('changeid', $fields);
        $this->assertContains('objectid', $fields);
        $this->assertContains('adrobjectid', $fields);
        $this->assertContains('opertypeid', $fields);
        $this->assertContains('ndocid', $fields);
        $this->assertContains('changedate', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing(): void
    {
        $model = new ChangeHistory();

        $this->assertFalse($model->getIncrementing());
    }
}
