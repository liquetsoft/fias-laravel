<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

/**
 * Преобразует данные в bool.
 *
 * @internal
 */
final class BoolCaster implements TypeCaster
{
    /**
     * {@inheritDoc}
     */
    public function canCast(string $type, mixed $value): bool
    {
        return $type === 'bool' || $type === 'boolean';
    }

    /**
     * {@inheritDoc}
     */
    public function cast(string $type, mixed $value): mixed
    {
        return (bool) $value;
    }
}
