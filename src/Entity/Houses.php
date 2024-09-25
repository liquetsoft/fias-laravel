<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по номерам домов улиц городов и населенных пунктов.
 *
 * @psalm-consistent-constructor
 *
 * @property int                $id         Уникальный идентификатор записи. Ключевое поле
 * @property int                $objectid   Глобальный уникальный идентификатор объекта типа INTEGER
 * @property string             $objectguid Глобальный уникальный идентификатор адресного объекта типа UUID
 * @property int                $changeid   ID изменившей транзакции
 * @property string|null        $housenum   Основной номер дома
 * @property string|null        $addnum1    Дополнительный номер дома 1
 * @property string|null        $addnum2    Дополнительный номер дома 1
 * @property int|null           $housetype  Основной тип дома
 * @property int|null           $addtype1   Дополнительный тип дома 1
 * @property int|null           $addtype2   Дополнительный тип дома 2
 * @property int                $opertypeid Статус действия над записью – причина появления записи
 * @property int|null           $previd     Идентификатор записи связывания с предыдущей исторической записью
 * @property int|null           $nextid     Идентификатор записи связывания с последующей исторической записью
 * @property \DateTimeInterface $updatedate Дата внесения (обновления) записи
 * @property \DateTimeInterface $startdate  Начало действия записи
 * @property \DateTimeInterface $enddate    Окончание действия записи
 * @property int                $isactual   Статус актуальности адресного объекта ФИАС
 * @property int                $isactive   Признак действующего адресного объекта
 */
final class Houses extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string|null */
    protected $table = 'fias_laravel_houses';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var array<int, string> */
    protected $fillable = [
        'id',
        'objectid',
        'objectguid',
        'changeid',
        'housenum',
        'addnum1',
        'addnum2',
        'housetype',
        'addtype1',
        'addtype2',
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
        'housenum' => 'string',
        'addnum1' => 'string',
        'addnum2' => 'string',
        'housetype' => 'integer',
        'addtype1' => 'integer',
        'addtype2' => 'integer',
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
