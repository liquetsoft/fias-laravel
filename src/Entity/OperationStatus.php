<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Перечень кодов операций над адресными объектами.
 *
 * @property int    $operstatid
 * @property string $name
 */
class OperationStatus extends Model
{
    /** @var string */
    protected $table = 'fias_laravel_operation_status';

    /** @var string[] */
    protected $fillable = [
        'operstatid',
        'name',
    ];

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
