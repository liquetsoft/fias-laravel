<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Перечень возможных статусов (центров) адресных объектов административных единиц.
 *
 * @property int    $centerstid
 * @property string $name
 */
class CenterStatus extends Model
{
    /** @var string */
    protected $table = 'fias_laravel_center_status';

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
