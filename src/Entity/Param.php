<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения о классификаторе параметров адресообразующих элементов и объектов недвижимости.
 *
 * @property int                $id          Идентификатор записи
 * @property int                $objectid    Глобальный уникальный идентификатор адресного объекта
 * @property int|null           $changeid    ID изменившей транзакции
 * @property int                $changeidend ID завершившей транзакции
 * @property int                $typeid      Тип параметра
 * @property string             $value       Значение параметра
 * @property \DateTimeInterface $updatedate  Дата внесения (обновления) записи
 * @property \DateTimeInterface $startdate   Дата начала действия записи
 * @property \DateTimeInterface $enddate     Дата окончания действия записи
 */
class Param extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_param';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'objectid',
        'changeid',
        'changeidend',
        'typeid',
        'value',
        'updatedate',
        'startdate',
        'enddate',
    ];

    /** @var array */
    protected $casts = [
        'id' => 'integer',
        'objectid' => 'integer',
        'changeid' => 'integer',
        'changeidend' => 'integer',
        'typeid' => 'integer',
        'value' => 'string',
        'updatedate' => 'datetime',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
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
