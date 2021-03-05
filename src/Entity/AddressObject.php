<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Классификатор адресообразующих элементов.
 *
 * @property string      $aoid       Уникальный идентификатор записи. Ключевое поле.
 * @property string      $aoguid     Глобальный уникальный идентификатор адресного объекта
 * @property string|null $parentguid Идентификатор объекта родительского объекта
 * @property string|null $previd     Идентификатор записи связывания с предыдушей исторической записью
 * @property string|null $nextid     Идентификатор записи  связывания с последующей исторической записью
 * @property string|null $code       Код адресного объекта одной строкой с признаком актуальности из КЛАДР 4.0.
 * @property string      $formalname Формализованное наименование
 * @property string|null $offname    Официальное наименование
 * @property string      $shortname  Краткое наименование типа объекта
 * @property int         $aolevel    Уровень адресного объекта
 * @property string      $regioncode Код региона
 * @property string      $areacode   Код района
 * @property string      $autocode   Код автономии
 * @property string      $citycode   Код города
 * @property string      $ctarcode   Код внутригородского района
 * @property string      $placecode  Код населенного пункта
 * @property string      $plancode   Код элемента планировочной структуры
 * @property string|null $streetcode Код улицы
 * @property string      $extrcode   Код дополнительного адресообразующего элемента
 * @property string      $sextcode   Код подчиненного дополнительного адресообразующего элемента
 * @property string|null $plaincode  Код адресного объекта из КЛАДР 4.0 одной строкой без признака актуальности (последних двух цифр)
 * @property int|null    $currstatus Статус актуальности КЛАДР 4 (последние две цифры в коде)
 * @property int         $actstatus  Статус актуальности адресного объекта ФИАС. Актуальный адрес на текущую дату. Обычно последняя запись об адресном объекте.
 *                                   0 – Не актуальный
 *                                   1 - Актуальный
 * @property int         $livestatus Признак действующего адресного объекта
 * @property int         $centstatus Статус центра
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
 * @property string|null $ifnsfl     Код ИФНС ФЛ
 * @property string|null $ifnsul     Код ИФНС ЮЛ
 * @property string|null $terrifnsfl Код территориального участка ИФНС ФЛ
 * @property string|null $terrifnsul Код территориального участка ИФНС ЮЛ
 * @property string|null $okato      OKATO
 * @property string|null $oktmo      OKTMO
 * @property string|null $postalcode Почтовый индекс
 * @property Carbon      $startdate  Начало действия записи
 * @property Carbon      $enddate    Окончание действия записи
 * @property Carbon      $updatedate Дата  внесения записи
 * @property int         $divtype    Тип адресации:
 *                                   0 - не определено
 *                                   1 - муниципальный;
 *                                   2 - административно-территориальный
 * @property string|null $normdoc    Внешний ключ на нормативный документ
 */
class AddressObject extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_address_object';

    /** @var string */
    protected $primaryKey = 'aoid';

    /** @var string */
    protected $keyType = 'string';

    /** @var string[] */
    protected $fillable = [
        'aoid',
        'aoguid',
        'parentguid',
        'previd',
        'nextid',
        'code',
        'formalname',
        'offname',
        'shortname',
        'aolevel',
        'regioncode',
        'areacode',
        'autocode',
        'citycode',
        'ctarcode',
        'placecode',
        'plancode',
        'streetcode',
        'extrcode',
        'sextcode',
        'plaincode',
        'currstatus',
        'actstatus',
        'livestatus',
        'centstatus',
        'operstatus',
        'ifnsfl',
        'ifnsul',
        'terrifnsfl',
        'terrifnsul',
        'okato',
        'oktmo',
        'postalcode',
        'startdate',
        'enddate',
        'updatedate',
        'divtype',
        'normdoc',
    ];

    /** @var array */
    protected $casts = [
        'aoid' => 'string',
        'aoguid' => 'string',
        'parentguid' => 'string',
        'previd' => 'string',
        'nextid' => 'string',
        'code' => 'string',
        'formalname' => 'string',
        'offname' => 'string',
        'shortname' => 'string',
        'aolevel' => 'integer',
        'regioncode' => 'string',
        'areacode' => 'string',
        'autocode' => 'string',
        'citycode' => 'string',
        'ctarcode' => 'string',
        'placecode' => 'string',
        'plancode' => 'string',
        'streetcode' => 'string',
        'extrcode' => 'string',
        'sextcode' => 'string',
        'plaincode' => 'string',
        'currstatus' => 'integer',
        'actstatus' => 'integer',
        'livestatus' => 'integer',
        'centstatus' => 'integer',
        'operstatus' => 'integer',
        'ifnsfl' => 'string',
        'ifnsul' => 'string',
        'terrifnsfl' => 'string',
        'terrifnsul' => 'string',
        'okato' => 'string',
        'oktmo' => 'string',
        'postalcode' => 'string',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
        'updatedate' => 'datetime',
        'divtype' => 'integer',
        'normdoc' => 'string',
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
