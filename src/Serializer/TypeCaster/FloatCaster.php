<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

/**
 * Преобразует данные в float.
 *
 * @internal
 */
final class FloatCaster implements TypeCaster
{
    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function canCast(string $type, mixed $value): bool
    {
        return $type === 'real' || $type === 'float' || $type === 'double' || strpos($type, 'decimal') === 0;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function cast(string $type, mixed $value): mixed
    {
        return (float) $value;
    }
}
