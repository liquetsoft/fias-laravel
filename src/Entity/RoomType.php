<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Тип комнаты.
 *
 * @property int         $rmtypeid  Тип комнаты
 * @property string      $name      Наименование
 * @property string|null $shortname Краткое наименование
 */
class RoomType extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_room_type';

    /** @var string */
    protected $primaryKey = 'rmtypeid';

    /** @var string[] */
    protected $fillable = [
        'rmtypeid',
        'name',
        'shortname',
    ];

    /** @var array */
    protected $casts = [
        'rmtypeid' => 'integer',
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
