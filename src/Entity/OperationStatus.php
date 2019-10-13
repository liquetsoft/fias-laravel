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
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'fias_laravel_operation_status';

    /** @var string[] */
    protected $fillable = [
        'operstatid',
        'name',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'operstatid' => 'integer',
        'name' => 'string',
    ];

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
