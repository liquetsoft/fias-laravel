<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

/**
 * Преобразует данные в timestamp.
 *
 * @internal
 */
final class TimestampCaster implements TypeCaster
{
    /**
     * {@inheritDoc}
     */
    public function canCast(string $type, mixed $value): bool
    {
        return strpos($type, 'timestamp') === 0;
    }

    /**
     * {@inheritDoc}
     */
    public function cast(string $type, mixed $value): mixed
    {
        if (is_numeric($value)) {
            return (int) $value;
        } else {
            return (new \DateTimeImmutable((string) $value))->getTimestamp();
        }
    }
}
