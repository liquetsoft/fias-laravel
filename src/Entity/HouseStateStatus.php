<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Перечень возможных состояний объектов недвижимости.
 *
 * @property int    $housestid
 * @property string $name
 */
class HouseStateStatus extends Model
{
    /** @var string */
    protected $table = 'fias_laravel_house_state_status';

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
