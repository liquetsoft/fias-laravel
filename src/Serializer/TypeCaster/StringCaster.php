<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

/**
 * Преобразует данные в string.
 *
 * @internal
 */
final class StringCaster implements TypeCaster
{
    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function canCast(string $type, mixed $value): bool
    {
        return $type === 'string' || $type === 'str';
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function cast(string $type, mixed $value): mixed
    {
        return (string) $value;
    }
}
