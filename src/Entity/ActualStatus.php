<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Перечень статусов актуальности записи адресного элемента по ФИАС.
 *
 * @property int    $actstatid
 * @property string $name
 */
class ActualStatus extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_actual_status';

    /** @var string */
    protected $primaryKey = 'actstatid';

    /** @var string[] */
    protected $fillable = [
        'actstatid',
        'name',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'actstatid' => 'integer',
        'name' => 'string',
    ];
}
