<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

/**
 * Преобразует данные в float.
 */
class FloatCaster implements TypeCaster
{
    /**
     * {@inheritDoc}
     */
    public function canCast(string $type, $value): bool
    {
        return $type === 'real' || $type === 'float' || $type === 'double' || strpos($type, 'decimal') === 0;
    }

    /**
     * {@inheritDoc}
     */
    public function cast(string $type, $value)
    {
        return (float) $value;
    }
}
