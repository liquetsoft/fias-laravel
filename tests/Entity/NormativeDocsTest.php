<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocs;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'NormativeDocs'.
 *
 * @internal
 */
final class NormativeDocsTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new NormativeDocs();

        $this->assertSame('fias_laravel_normative_docs', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new NormativeDocs();
        $fields = $model->getFillable();

        $this->assertContains('id', $fields);
        $this->assertContains('name', $fields);
        $this->assertContains('date', $fields);
        $this->assertContains('number', $fields);
        $this->assertContains('type', $fields);
        $this->assertContains('kind', $fields);
        $this->assertContains('updatedate', $fields);
        $this->assertContains('orgname', $fields);
        $this->assertContains('regnum', $fields);
        $this->assertContains('regdate', $fields);
        $this->assertContains('accdate', $fields);
        $this->assertContains('comment', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing(): void
    {
        $model = new NormativeDocs();

        $this->assertFalse($model->getIncrementing());
    }
}
