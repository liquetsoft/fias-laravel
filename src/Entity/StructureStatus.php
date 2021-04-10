<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Признак строения.
 *
 * @property int         $strstatid Признак строения
 * @property string      $name      Наименование
 * @property string|null $shortname Краткое наименование
 */
class StructureStatus extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_structure_status';

    /** @var string */
    protected $primaryKey = 'strstatid';

    /** @var string[] */
    protected $fillable = [
        'strstatid',
        'name',
        'shortname',
    ];

    /** @var array */
    protected $casts = [
        'strstatid' => 'integer',
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
