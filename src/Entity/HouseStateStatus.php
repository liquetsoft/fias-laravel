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
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'fias_laravel_house_state_status';

    /** @var string */
    protected $primaryKey = 'housestid';

    /** @var string[] */
    protected $fillable = [
        'housestid',
        'name',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'housestid' => 'integer',
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
