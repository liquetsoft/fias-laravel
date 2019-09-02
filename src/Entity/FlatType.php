<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Перечень типов помещения или офиса.
 *
 * @property int    $fltypeid
 * @property string $name
 * @property string $shortname
 */
class FlatType extends Model
{
    /** @var string */
    protected $table = 'fias_laravel_flat_type';

    /** @var string[] */
    protected $fillable = [
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
