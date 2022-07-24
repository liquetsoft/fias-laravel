<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Сведения об адресном элементе в части его идентификаторов.
 *
 * @property int               $objectid   Уникальный идентификатор объекта
 * @property DateTimeInterface $createdate Дата создания
 * @property int               $changeid   ID изменившей транзакции
 * @property int               $levelid    Уровень объекта
 * @property DateTimeInterface $updatedate Дата обновления
 * @property string            $objectguid GUID объекта
 * @property int               $isactive   Признак действующего объекта (1 - действующий, 0 - не действующий)
 */
class ReestrObjects extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_reestr_objects';

    /** @var string */
    protected $primaryKey = 'objectid';

    /** @var string[] */
    protected $fillable = [
        'objectid',
        'createdate',
        'changeid',
        'levelid',
        'updatedate',
        'objectguid',
        'isactive',
    ];

    /** @var array */
    protected $casts = [
        'objectid' => 'integer',
        'createdate' => 'datetime',
        'changeid' => 'integer',
        'levelid' => 'integer',
        'updatedate' => 'datetime',
        'objectguid' => 'string',
        'isactive' => 'integer',
    ];

    /**
     * {@inheritDoc}
     *
     * @psalm-suppress MixedMethodCall
     */
    public function getConnectionName()
    {
        $connection = $this->connection;
        if (\function_exists('app') && app()->has('config')) {
            /** @var string|null */
            $connection = app('config')->get('liquetsoft_fias.eloquent_connection') ?: $this->connection;
        }

        return $connection;
    }
}
