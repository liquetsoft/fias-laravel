<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

use Exception;

/**
 * Преобразует данные в дату.
 */
class DateCaster implements TypeCaster
{
    /**
     * {@inheritDoc}
     */
    public function canCast(string $type, $value): bool
    {
        return strpos($type, 'date') === 0;
    }

    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public function cast(string $type, $value)
    {
        return new \DateTimeImmutable((string) $value);
    }
}
