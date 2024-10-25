<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel;

/**
 * Мок для проверки десериализации json.
 */
final class FiasSerializerMockJson
{
    public int $id = 0;
    public string $name = '';
    public float $floatNum = .0;
    public ?\DateTimeInterface $date = null;
}
