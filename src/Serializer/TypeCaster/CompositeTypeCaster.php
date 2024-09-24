<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

/**
 * Кастер, который выбирает подходящий кастер из внутреннего набора кастеров.
 *
 * @internal
 */
final class CompositeTypeCaster implements TypeCaster
{
    /**
     * @param TypeCaster[] $casters
     */
    public function __construct(private readonly array $casters = [])
    {
    }

    /**
     * {@inheritDoc}
     */
    public function canCast(string $type, mixed $value): bool
    {
        foreach ($this->casters as $caster) {
            if ($caster->canCast($type, $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function cast(string $type, mixed $value): mixed
    {
        foreach ($this->casters as $caster) {
            if ($caster->canCast($type, $value)) {
                return $caster->cast($type, $value);
            }
        }

        return $value;
    }
}
