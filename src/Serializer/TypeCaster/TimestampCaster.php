<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

use DateTime;
use Exception;

/**
 * Преобразует данные в timestamp.
 */
class TimestampCaster implements TypeCaster
{
    /**
     * @inheritDoc
     */
    public function canCast(string $type, $value): bool
    {
        return strpos($type, 'timestamp') === 0;
    }

    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public function cast(string $type, $value)
    {
        return is_numeric($value) ? (int) $value : (new DateTime($value))->getTimestamp();
    }
}
