<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по иерархии в муниципальном делении.
 *
 * @property int               $id          Уникальный идентификатор записи. Ключевое поле
 * @property int               $objectid    Глобальный уникальный идентификатор адресного объекта
 * @property int|null          $parentobjid Идентификатор родительского объекта
 * @property int               $changeid    ID изменившей транзакции
 * @property string|null       $oktmo       Код ОКТМО
 * @property int|null          $previd      Идентификатор записи связывания с предыдущей исторической записью
 * @property int|null          $nextid      Идентификатор записи связывания с последующей исторической записью
 * @property DateTimeInterface $updatedate  Дата внесения (обновления) записи
 * @property DateTimeInterface $startdate   Начало действия записи
 * @property DateTimeInterface $enddate     Окончание действия записи
 * @property int               $isactive    Признак действующего адресного объекта
 */
class MunHierarchy extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_mun_hierarchy';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'objectid',
        'parentobjid',
        'changeid',
        'oktmo',
        'previd',
        'nextid',
        'updatedate',
        'startdate',
        'enddate',
        'isactive',
    ];

    /** @var array */
    protected $casts = [
        'id' => 'integer',
        'objectid' => 'integer',
        'parentobjid' => 'integer',
        'changeid' => 'integer',
        'oktmo' => 'string',
        'previd' => 'integer',
        'nextid' => 'integer',
        'updatedate' => 'datetime',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
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
