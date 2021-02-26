<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по номерам домов улиц городов и населенных пунктов.
 *
 * @property string      $houseid    Уникальный идентификатор записи дома
 * @property string      $houseguid  Глобальный уникальный идентификатор дома
 * @property string      $aoguid     Guid записи родительского объекта (улицы, города, населенного пункта и т.п.)
 * @property string|null $housenum   Номер дома
 * @property int|null    $strstatus  Признак строения
 * @property int         $eststatus  Признак владения
 * @property int         $statstatus Состояние дома
 * @property string|null $ifnsfl     Код ИФНС ФЛ
 * @property string|null $ifnsul     Код ИФНС ЮЛ
 * @property string|null $okato      OKATO
 * @property string|null $oktmo      OKTMO
 * @property string|null $postalcode Почтовый индекс
 * @property Carbon      $startdate  Начало действия записи
 * @property Carbon      $enddate    Окончание действия записи
 * @property Carbon      $updatedate Дата время внесения записи
 * @property int         $counter    Счетчик записей домов для КЛАДР 4
 * @property int         $divtype    Тип адресации:
 *                                   0 - не определено
 *                                   1 - муниципальный;
 *                                   2 - административно-территориальный
 * @property string|null $regioncode Код региона
 * @property string|null $terrifnsfl Код территориального участка ИФНС ФЛ
 * @property string|null $terrifnsul Код территориального участка ИФНС ЮЛ
 * @property string|null $buildnum   Номер корпуса
 * @property string|null $strucnum   Номер строения
 * @property string|null $normdoc    Внешний ключ на нормативный документ
 * @property string|null $cadnum     Кадастровый номер
 */
class House extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_house';

    /** @var string */
    protected $primaryKey = 'houseid';

    /** @var string */
    protected $keyType = 'string';

    /** @var string[] */
    protected $fillable = [
        'houseid',
        'houseguid',
        'aoguid',
        'housenum',
        'strstatus',
        'eststatus',
        'statstatus',
        'ifnsfl',
        'ifnsul',
        'okato',
        'oktmo',
        'postalcode',
        'startdate',
        'enddate',
        'updatedate',
        'counter',
        'divtype',
        'regioncode',
        'terrifnsfl',
        'terrifnsul',
        'buildnum',
        'strucnum',
        'normdoc',
        'cadnum',
    ];

    /** @var array */
    protected $casts = [
        'houseid' => 'string',
        'houseguid' => 'string',
        'aoguid' => 'string',
        'housenum' => 'string',
        'strstatus' => 'integer',
        'eststatus' => 'integer',
        'statstatus' => 'integer',
        'ifnsfl' => 'string',
        'ifnsul' => 'string',
        'okato' => 'string',
        'oktmo' => 'string',
        'postalcode' => 'string',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
        'updatedate' => 'datetime',
        'counter' => 'integer',
        'divtype' => 'integer',
        'regioncode' => 'string',
        'terrifnsfl' => 'string',
        'terrifnsul' => 'string',
        'buildnum' => 'string',
        'strucnum' => 'string',
        'normdoc' => 'string',
        'cadnum' => 'string',
    ];
}
