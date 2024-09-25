<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения об адресном элементе в части его идентификаторов.
 *
 * @psalm-consistent-constructor
 *
 * @property int                $objectid   Уникальный идентификатор объекта
 * @property \DateTimeInterface $createdate Дата создания
 * @property int                $changeid   ID изменившей транзакции
 * @property int                $levelid    Уровень объекта
 * @property \DateTimeInterface $updatedate Дата обновления
 * @property string             $objectguid GUID объекта
 * @property int                $isactive   Признак действующего объекта (1 - действующий, 0 - не действующий)
 */
final class ReestrObjects extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'fias_laravel_reestr_objects';
    protected $primaryKey = 'objectid';

    protected $fillable = [
        'objectid',
        'createdate',
        'changeid',
        'levelid',
        'updatedate',
        'objectguid',
        'isactive',
    ];

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
        if (\function_exists('app') && app()->has('config') === true) {
            /** @var string|null */
            $connection = app('config')->get('liquetsoft_fias.eloquent_connection') ?: $this->connection;
        }

        return $connection;
    }
}
