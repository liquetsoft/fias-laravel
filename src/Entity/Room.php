<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Классификатор помещениях.
 *
 * @property string      $roomid     Уникальный идентификатор записи. Ключевое поле.
 * @property string      $roomguid   Глобальный уникальный идентификатор адресного объекта (помещения)
 * @property string      $houseguid  Идентификатор родительского объекта (дома)
 * @property string      $regioncode Код региона
 * @property string      $flatnumber Номер помещения или офиса
 * @property int         $flattype   Тип помещения
 * @property string|null $postalcode Почтовый индекс
 * @property Carbon      $startdate  Начало действия записи
 * @property Carbon      $enddate    Окончание действия записи
 * @property Carbon      $updatedate Дата  внесения записи
 * @property int         $operstatus Статус действия над записью – причина появления записи (см. описание таблицы OperationStatus):
 *                                   01 – Инициация;
 *                                   10 – Добавление;
 *                                   20 – Изменение;
 *                                   21 – Групповое изменение;
 *                                   30 – Удаление;
 *                                   31 - Удаление вследствие удаления вышестоящего объекта;
 *                                   40 – Присоединение адресного объекта (слияние);
 *                                   41 – Переподчинение вследствие слияния вышестоящего объекта;
 *                                   42 - Прекращение существования вследствие присоединения к другому адресному объекту;
 *                                   43 - Создание нового адресного объекта в результате слияния адресных объектов;
 *                                   50 – Переподчинение;
 *                                   51 – Переподчинение вследствие переподчинения вышестоящего объекта;
 *                                   60 – Прекращение существования вследствие дробления;
 *                                   61 – Создание нового адресного объекта в результате дробления
 * @property int         $livestatus Признак действующего адресного объекта
 * @property string|null $normdoc    Внешний ключ на нормативный документ
 * @property string|null $roomnumber Номер комнаты
 * @property int|null    $roomtype   Тип комнаты
 * @property string|null $previd     Идентификатор записи связывания с предыдушей исторической записью
 * @property string|null $nextid     Идентификатор записи  связывания с последующей исторической записью
 * @property string|null $cadnum     Кадастровый номер помещения
 * @property string|null $roomcadnum Кадастровый номер комнаты в помещении
 */
class Room extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_room';

    /** @var string */
    protected $primaryKey = 'roomid';

    /** @var string */
    protected $keyType = 'string';

    /** @var string[] */
    protected $fillable = [
        'roomid',
        'roomguid',
        'houseguid',
        'regioncode',
        'flatnumber',
        'flattype',
        'postalcode',
        'startdate',
        'enddate',
        'updatedate',
        'operstatus',
        'livestatus',
        'normdoc',
        'roomnumber',
        'roomtype',
        'previd',
        'nextid',
        'cadnum',
        'roomcadnum',
    ];

    /** @var array */
    protected $casts = [
        'roomid' => 'string',
        'roomguid' => 'string',
        'houseguid' => 'string',
        'regioncode' => 'string',
        'flatnumber' => 'string',
        'flattype' => 'integer',
        'postalcode' => 'string',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
        'updatedate' => 'datetime',
        'operstatus' => 'integer',
        'livestatus' => 'integer',
        'normdoc' => 'string',
        'roomnumber' => 'string',
        'roomtype' => 'integer',
        'previd' => 'string',
        'nextid' => 'string',
        'cadnum' => 'string',
        'roomcadnum' => 'string',
    ];

    /**
     * {@inheritDoc}
     */
    public function getConnectionName()
    {
        $connection = $this->connection;
        if (function_exists('app') && app()->has('config')) {
            $connection = app('config')->get('liquetsoft_fias.eloquent_connection') ?: $this->connection;
        }

        return $connection;
    }
}
