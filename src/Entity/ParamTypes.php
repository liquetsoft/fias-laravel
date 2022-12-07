<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по типу параметра.
 *
 * @property int                $id         Идентификатор типа параметра (ключ)
 * @property string             $name       Наименование
 * @property string             $code       Краткое наименование
 * @property string|null        $desc       Описание
 * @property \DateTimeInterface $updatedate Дата внесения (обновления) записи
 * @property \DateTimeInterface $startdate  Начало действия записи
 * @property \DateTimeInterface $enddate    Окончание действия записи
 * @property string             $isactive   Статус активности
 */
class ParamTypes extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_param_types';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'name',
        'code',
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
        'code' => 'string',
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
