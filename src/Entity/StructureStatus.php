<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Перечень видов строений.
 *
 * @property int    $strstatid
 * @property string $name
 * @property string $shortname
 */
class StructureStatus extends Model
{
    /** @var string */
    protected $table = 'fias_laravel_structure_status';

    /** @var string[] */
    protected $fillable = [
        'strstatid',
        'name',
        'shortname',
    ];

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
