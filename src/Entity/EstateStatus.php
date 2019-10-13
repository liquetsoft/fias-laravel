<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Перечень возможных видов владений.
 *
 * @property int    $eststatid
 * @property string $name
 */
class EstateStatus extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'fias_laravel_estate_status';

    /** @var string */
    protected $primaryKey = 'eststatid';

    /** @var string[] */
    protected $fillable = [
        'eststatid',
        'name',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'eststatid' => 'integer',
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
