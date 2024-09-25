<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по уровням адресных объектов.
 *
 * @psalm-consistent-constructor
 *
 * @property int                $level      Уникальный идентификатор записи. Ключевое поле. Номер уровня объекта
 * @property string             $name       Наименование
 * @property string|null        $shortname  Краткое наименование
 * @property \DateTimeInterface $updatedate Дата внесения (обновления) записи
 * @property \DateTimeInterface $startdate  Начало действия записи
 * @property \DateTimeInterface $enddate    Окончание действия записи
 * @property string             $isactive   Признак действующего адресного объекта
 */
final class ObjectLevels extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'fias_laravel_object_levels';
    protected $primaryKey = 'level';

    protected $fillable = [
        'level',
        'name',
        'shortname',
        'updatedate',
        'startdate',
        'enddate',
        'isactive',
    ];

    protected $casts = [
        'level' => 'integer',
        'name' => 'string',
        'shortname' => 'string',
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
