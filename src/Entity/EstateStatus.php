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
    /** @var string */
    protected $table = 'fias_laravel_estate_status';

    /** @var string[] */
    protected $fillable = [
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
