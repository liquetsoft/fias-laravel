<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Статус центра.
 *
 * @property int    $centerstid Идентификатор статуса
 * @property string $name       Наименование
 */
class CenterStatus extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_center_status';

    /** @var string */
    protected $primaryKey = 'centerstid';

    /** @var string[] */
    protected $fillable = [
        'centerstid',
        'name',
    ];

    /** @var array */
    protected $casts = [
        'centerstid' => 'integer',
        'name' => 'string',
    ];
}
