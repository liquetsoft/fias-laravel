<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

/**
 * Кастер для преобразования типов в eloquent модели.
 */
class EloquentTypeCaster extends CompositeTypeCaster
{
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

        parent::__construct($casters);
    }
}
