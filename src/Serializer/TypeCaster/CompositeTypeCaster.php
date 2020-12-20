<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

/**
 * Кастер, который выбирает подходящий кастер из внутреннего набора кастеров.
 */
class CompositeTypeCaster implements TypeCaster
{
    /**
     * @var TypeCaster[]
     */
    protected $casters = [];

    /**
     * @param TypeCaster[] $casters
     */
    public function __construct(array $casters = [])
    {
        $this->casters = $casters;
    }

    /**
     * {@inheritDoc}
     */
    public function canCast(string $type, $value): bool
    {
        $canCast = false;

        foreach ($this->casters as $caster) {
            if ($caster->canCast($type, $value)) {
                $canCast = true;
                break;
            }
        }

        return $canCast;
    }

    /**
     * {@inheritDoc}
     */
    public function cast(string $type, $value)
    {
        $castedValue = $value;

        foreach ($this->casters as $caster) {
            if ($caster->canCast($type, $value)) {
                $castedValue = $caster->cast($type, $value);
                break;
            }
        }

        return $castedValue;
    }
}
