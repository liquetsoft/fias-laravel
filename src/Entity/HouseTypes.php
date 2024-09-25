<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по типам домов.
 *
 * @psalm-consistent-constructor
 *
 * @property int                $id         Идентификатор
 * @property string             $name       Наименование
 * @property string|null        $shortname  Краткое наименование
 * @property string|null        $desc       Описание
 * @property \DateTimeInterface $updatedate Дата внесения (обновления) записи
 * @property \DateTimeInterface $startdate  Начало действия записи
 * @property \DateTimeInterface $enddate    Окончание действия записи
 * @property string             $isactive   Статус активности
 */
final class HouseTypes extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'fias_laravel_house_types';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'shortname',
        'desc',
        'updatedate',
        'startdate',
        'enddate',
        'isactive',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'shortname' => 'string',
        'desc' => 'string',
        'updatedate' => 'datetime',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
        'isactive' => 'string',
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
