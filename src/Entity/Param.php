<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения о классификаторе параметров адресообразующих элементов и объектов недвижимости.
 *
 * @psalm-consistent-constructor
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
final class Param extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'fias_laravel_param';
    protected $primaryKey = 'id';

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
    #[\Override]
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
