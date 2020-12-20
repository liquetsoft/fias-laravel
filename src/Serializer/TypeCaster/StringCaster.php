<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

/**
 * Преобразует данные в string.
 */
class StringCaster implements TypeCaster
{
    /**
     * {@inheritDoc}
     */
    public function canCast(string $type, $value): bool
    {
        return $type === 'string' || $type === 'str';
    }

    /**
     * {@inheritDoc}
     */
    public function cast(string $type, $value)
    {
        return (string) $value;
    }
}
