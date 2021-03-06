<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Entity;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocument;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест для модели 'NormativeDocument'.
 *
 * @internal
 */
class NormativeDocumentTest extends BaseCase
{
    /**
     * Проверяет, что модель привязана к правильной таблице в базе.
     */
    public function testGetTable(): void
    {
        $model = new NormativeDocument();

        $this->assertSame('fias_laravel_normative_document', $model->getTable());
    }

    /**
     * Проверяет, что в модели доступны для заполнения все поля.
     */
    public function testGetFillable(): void
    {
        $model = new NormativeDocument();
        $fields = $model->getFillable();

        $this->assertContains('normdocid', $fields);
        $this->assertContains('docname', $fields);
        $this->assertContains('docdate', $fields);
        $this->assertContains('docnum', $fields);
        $this->assertContains('doctype', $fields);
        $this->assertContains('docimgid', $fields);
    }

    /**
     * Проверяет, что в модель не исрользует autoincrement.
     */
    public function testGetIncrementing(): void
    {
        $model = new NormativeDocument();

        $this->assertFalse($model->getIncrementing());
    }

    /**
     * Проверяет, что в модели правильно задана обработка первичного ключа.
     */
    public function testGetKeyType(): void
    {
        $model = new NormativeDocument();

        $this->assertSame('string', $model->getKeyType());
    }
}
