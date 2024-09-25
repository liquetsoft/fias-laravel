<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

/**
 * Кастер для преобразования типов в eloquent модели.
 *
 * @internal
 */
final class EloquentTypeCaster implements TypeCaster
{
    private readonly TypeCaster $internalTypeCaster;

    /**
     * @param TypeCaster[]|null $casters
     */
    public function __construct(?array $casters = null)
    {
        if ($casters === null) {
            $casters = [
                new BoolCaster(),
                new DateCaster(),
                new FloatCaster(),
                new IntCaster(),
                new StringCaster(),
                new TimestampCaster(),
            ];
        }

        $this->internalTypeCaster = new CompositeTypeCaster($casters);
    }

    /**
     * {@inheritDoc}
     */
    public function canCast(string $type, mixed $value): bool
    {
        return $this->internalTypeCaster->canCast($type, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function cast(string $type, mixed $value): mixed
    {
        return $this->internalTypeCaster->cast($type, $value);
    }
}
