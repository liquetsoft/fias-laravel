<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по типам домов.
 *
 * @property int               $id         Идентификатор
 * @property string            $name       Наименование
 * @property string|null       $shortname  Краткое наименование
 * @property string|null       $desc       Описание
 * @property DateTimeInterface $updatedate Дата внесения (обновления) записи
 * @property DateTimeInterface $startdate  Начало действия записи
 * @property DateTimeInterface $enddate    Окончание действия записи
 * @property string            $isactive   Статус активности
 */
class HouseTypes extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_house_types';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
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

    /** @var array */
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
        if (\function_exists('app') && app()->has('config')) {
            /** @var string|null */
            $connection = app('config')->get('liquetsoft_fias.eloquent_connection') ?: $this->connection;
        }

        return $connection;
    }
}
