<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по иерархии в муниципальном делении.
 *
 * @psalm-consistent-constructor
 *
 * @property int                $id          Уникальный идентификатор записи. Ключевое поле
 * @property int                $objectid    Глобальный уникальный идентификатор адресного объекта
 * @property int|null           $parentobjid Идентификатор родительского объекта
 * @property int                $changeid    ID изменившей транзакции
 * @property string|null        $oktmo       Код ОКТМО
 * @property int|null           $previd      Идентификатор записи связывания с предыдущей исторической записью
 * @property int|null           $nextid      Идентификатор записи связывания с последующей исторической записью
 * @property \DateTimeInterface $updatedate  Дата внесения (обновления) записи
 * @property \DateTimeInterface $startdate   Начало действия записи
 * @property \DateTimeInterface $enddate     Окончание действия записи
 * @property int                $isactive    Признак действующего адресного объекта
 * @property string             $path        Материализованный путь к объекту (полная иерархия)
 */
final class MunHierarchy extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'fias_laravel_mun_hierarchy';
    protected $primaryKey = 'id';

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
        'path',
    ];

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
        if (\function_exists('app') && app()->has('config') === true) {
            /** @var string|null */
            $connection = app('config')->get('liquetsoft_fias.eloquent_connection') ?: $this->connection;
        }

        return $connection;
    }
}
