<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocsKinds;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'NormativeDocsKinds'.
 *
 * @internal
 */
class NormativeDocsKindsTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new NormativeDocsKinds();

        $this->assertSame('fias_laravel_normative_docs_kinds', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new NormativeDocsKinds();
        $fields = $model->getFillable();

        $this->assertContains('id', $fields);
        $this->assertContains('name', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing(): void
    {
        $model = new NormativeDocsKinds();

        $this->assertFalse($model->getIncrementing());
    }
}
