<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Перечень статусов актуальности записи адресного элемента по классификатору КЛАДР4.0.
 *
 * @property int    $curentstid
 * @property string $name
 */
class CurrentStatus extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'fias_laravel_current_status';

    /** @var string */
    protected $primaryKey = 'curentstid';

    /** @var string[] */
    protected $fillable = [
        'curentstid',
        'name',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'curentstid' => 'integer',
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
