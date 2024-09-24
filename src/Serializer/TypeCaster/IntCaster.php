<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

/**
 * Преобразует данные в int.
 *
 * @internal
 */
final class IntCaster implements TypeCaster
{
    /**
     * {@inheritDoc}
     */
    public function canCast(string $type, mixed $value): bool
    {
        return $type === 'int' || $type === 'integer';
    }

    /**
     * {@inheritDoc}
     */
    public function cast(string $type, mixed $value): mixed
    {
        return (int) $value;
    }
}
