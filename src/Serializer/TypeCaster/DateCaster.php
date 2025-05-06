<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

/**
 * Преобразует данные в дату.
 *
 * @internal
 */
final class DateCaster implements TypeCaster
{
    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function canCast(string $type, mixed $value): bool
    {
        return strpos($type, 'date') === 0;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    public function cast(string $type, mixed $value): mixed
    {
        return new \DateTimeImmutable((string) $value);
    }
}
