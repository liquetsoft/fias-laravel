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
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'fias_laravel_flat_type';

    /** @var string */
    protected $primaryKey = 'fltypeid';

    /** @var string[] */
    protected $fillable = [
        'fltypeid',
        'name',
        'shortname',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'fltypeid' => 'integer',
        'name' => 'string',
        'shortname' => 'string',
    ];

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
