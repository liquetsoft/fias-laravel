<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Классификатор земельных участков.
 *
 * @property string      $steadguid  Глобальный уникальный идентификатор адресного объекта (земельного участка)
 * @property string|null $number     Номер земельного участка
 * @property string      $regioncode Код региона
 * @property string|null $postalcode Почтовый индекс
 * @property string|null $ifnsfl     Код ИФНС ФЛ
 * @property string|null $ifnsul     Код ИФНС ЮЛ
 * @property string|null $okato      OKATO
 * @property string|null $oktmo      OKTMO
 * @property string|null $parentguid Идентификатор объекта родительского объекта
 * @property string      $steadid    Уникальный идентификатор записи. Ключевое поле.
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
 * @property Carbon      $startdate  Начало действия записи
 * @property Carbon      $enddate    Окончание действия записи
 * @property Carbon      $updatedate Дата  внесения записи
 * @property int         $livestatus Признак действующего адресного объекта
 * @property int         $divtype    Тип адресации:
 *                                   0 - не определено
 *                                   1 - муниципальный;
 *                                   2 - административно-территориальный
 * @property string|null $normdoc    Внешний ключ на нормативный документ
 * @property string|null $terrifnsfl Код территориального участка ИФНС ФЛ
 * @property string|null $terrifnsul Код территориального участка ИФНС ЮЛ
 * @property string|null $previd     Идентификатор записи связывания с предыдушей исторической записью
 * @property string|null $nextid     Идентификатор записи  связывания с последующей исторической записью
 * @property string|null $cadnum     Кадастровый номер
 */
class Stead extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_stead';

    /** @var string */
    protected $primaryKey = 'steadid';

    /** @var string */
    protected $keyType = 'string';

    /** @var string[] */
    protected $fillable = [
        'steadguid',
        'number',
        'regioncode',
        'postalcode',
        'ifnsfl',
        'ifnsul',
        'okato',
        'oktmo',
        'parentguid',
        'steadid',
        'operstatus',
        'startdate',
        'enddate',
        'updatedate',
        'livestatus',
        'divtype',
        'normdoc',
        'terrifnsfl',
        'terrifnsul',
        'previd',
        'nextid',
        'cadnum',
    ];

    /** @var array */
    protected $casts = [
        'steadguid' => 'string',
        'number' => 'string',
        'regioncode' => 'string',
        'postalcode' => 'string',
        'ifnsfl' => 'string',
        'ifnsul' => 'string',
        'okato' => 'string',
        'oktmo' => 'string',
        'parentguid' => 'string',
        'steadid' => 'string',
        'operstatus' => 'integer',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
        'updatedate' => 'datetime',
        'livestatus' => 'integer',
        'divtype' => 'integer',
        'normdoc' => 'string',
        'terrifnsfl' => 'string',
        'terrifnsul' => 'string',
        'previd' => 'string',
        'nextid' => 'string',
        'cadnum' => 'string',
    ];
}
