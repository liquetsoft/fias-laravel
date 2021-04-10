<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Признак владения.
 *
 * @property int         $eststatid Признак владения
 * @property string      $name      Наименование
 * @property string|null $shortname Краткое наименование
 */
class EstateStatus extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_estate_status';

    /** @var string */
    protected $primaryKey = 'eststatid';

    /** @var string[] */
    protected $fillable = [
        'eststatid',
        'name',
        'shortname',
    ];

    /** @var array */
    protected $casts = [
        'eststatid' => 'integer',
        'name' => 'string',
        'shortname' => 'string',
    ];

    /**
     * {@inheritDoc}
     */
    public function getConnectionName()
    {
        $connection = $this->connection;
        if (\function_exists('app') && app()->has('config')) {
            $connection = app('config')->get('liquetsoft_fias.eloquent_connection') ?: $this->connection;
        }

        return $connection;
    }
}
