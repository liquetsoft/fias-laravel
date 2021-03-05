<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Тип помещения.
 *
 * @property int         $fltypeid  Тип помещения
 * @property string      $name      Наименование
 * @property string|null $shortname Краткое наименование
 */
class FlatType extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

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

    /** @var array */
    protected $casts = [
        'fltypeid' => 'integer',
        'name' => 'string',
        'shortname' => 'string',
    ];

    /**
     * {@inheritDoc}
     */
    public function getConnectionName()
    {
        $connection = $this->connection;
        if (function_exists('app') && app()->has('config')) {
            $connection = app('config')->get('liquetsoft_fias.eloquent_connection') ?: $this->connection;
        }

        return $connection;
    }
}
