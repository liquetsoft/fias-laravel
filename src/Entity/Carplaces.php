<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по машино-местам.
 *
 * @property int               $id         Уникальный идентификатор записи. Ключевое поле
 * @property int               $objectid   Глобальный уникальный идентификатор объекта типа INTEGER
 * @property string            $objectguid Глобальный уникальный идентификатор адресного объекта типа UUID
 * @property int               $changeid   ID изменившей транзакции
 * @property string            $number     Номер машиноместа
 * @property int               $opertypeid Статус действия над записью – причина появления записи
 * @property int|null          $previd     Идентификатор записи связывания с предыдущей исторической записью
 * @property int|null          $nextid     Идентификатор записи связывания с последующей исторической записью
 * @property DateTimeInterface $updatedate Дата внесения (обновления) записи
 * @property DateTimeInterface $startdate  Начало действия записи
 * @property DateTimeInterface $enddate    Окончание действия записи
 * @property int               $isactual   Статус актуальности адресного объекта ФИАС
 * @property int               $isactive   Признак действующего адресного объекта
 */
class Carplaces extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_carplaces';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'objectid',
        'objectguid',
        'changeid',
        'number',
        'opertypeid',
        'previd',
        'nextid',
        'updatedate',
        'startdate',
        'enddate',
        'isactual',
        'isactive',
    ];

    /** @var array */
    protected $casts = [
        'id' => 'integer',
        'objectid' => 'integer',
        'objectguid' => 'string',
        'changeid' => 'integer',
        'number' => 'string',
        'opertypeid' => 'integer',
        'previd' => 'integer',
        'nextid' => 'integer',
        'updatedate' => 'datetime',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
        'isactual' => 'integer',
        'isactive' => 'integer',
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
