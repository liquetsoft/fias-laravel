<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по истории изменений.
 *
 * @psalm-consistent-constructor
 *
 * @property int                $changeid    ID изменившей транзакции
 * @property int                $objectid    Уникальный ID объекта
 * @property string             $adrobjectid Уникальный ID изменившей транзакции (GUID)
 * @property int                $opertypeid  Тип операции
 * @property int|null           $ndocid      ID документа
 * @property \DateTimeInterface $changedate  Дата изменения
 */
final class ChangeHistory extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string|null */
    protected $table = 'fias_laravel_change_history';

    /** @var string */
    protected $primaryKey = 'changeid';

    /** @var array<int, string> */
    protected $fillable = [
        'changeid',
        'objectid',
        'adrobjectid',
        'opertypeid',
        'ndocid',
        'changedate',
    ];

    /** @var array */
    protected $casts = [
        'changeid' => 'integer',
        'objectid' => 'integer',
        'adrobjectid' => 'string',
        'opertypeid' => 'integer',
        'ndocid' => 'integer',
        'changedate' => 'datetime',
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
