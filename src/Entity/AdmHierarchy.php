<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по иерархии в административном делении.
 *
 * @property int                $id          Уникальный идентификатор записи. Ключевое поле
 * @property int                $objectid    Глобальный уникальный идентификатор объекта
 * @property int|null           $parentobjid Идентификатор родительского объекта
 * @property int                $changeid    ID изменившей транзакции
 * @property string|null        $regioncode  Код региона
 * @property string|null        $areacode    Код района
 * @property string|null        $citycode    Код города
 * @property string|null        $placecode   Код населенного пункта
 * @property string|null        $plancode    Код ЭПС
 * @property string|null        $streetcode  Код улицы
 * @property int|null           $previd      Идентификатор записи связывания с предыдущей исторической записью
 * @property int|null           $nextid      Идентификатор записи связывания с последующей исторической записью
 * @property \DateTimeInterface $updatedate  Дата внесения (обновления) записи
 * @property \DateTimeInterface $startdate   Начало действия записи
 * @property \DateTimeInterface $enddate     Окончание действия записи
 * @property int                $isactive    Признак действующего адресного объекта
 * @property string             $path        Материализованный путь к объекту (полная иерархия)
 */
class AdmHierarchy extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_adm_hierarchy';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'objectid',
        'parentobjid',
        'changeid',
        'regioncode',
        'areacode',
        'citycode',
        'placecode',
        'plancode',
        'streetcode',
        'previd',
        'nextid',
        'updatedate',
        'startdate',
        'enddate',
        'isactive',
        'path',
    ];

    /** @var array */
    protected $casts = [
        'id' => 'integer',
        'objectid' => 'integer',
        'parentobjid' => 'integer',
        'changeid' => 'integer',
        'regioncode' => 'string',
        'areacode' => 'string',
        'citycode' => 'string',
        'placecode' => 'string',
        'plancode' => 'string',
        'streetcode' => 'string',
        'previd' => 'integer',
        'nextid' => 'integer',
        'updatedate' => 'datetime',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
        'isactive' => 'integer',
        'path' => 'string',
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
