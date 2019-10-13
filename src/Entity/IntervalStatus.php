<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Перечень возможных значений интервалов домов (обычный, четный, нечетный).
 *
 * @property int    $intvstatid
 * @property string $name
 */
class IntervalStatus extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_interval_status';

    /** @var string */
    protected $primaryKey = 'intvstatid';

    /** @var string[] */
    protected $fillable = [
        'intvstatid',
        'name',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'intvstatid' => 'integer',
        'name' => 'string',
    ];
}
