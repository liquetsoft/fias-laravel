<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по типам нормативных документов.
 *
 * @psalm-consistent-constructor
 *
 * @property int                $id        Идентификатор записи
 * @property string             $name      Наименование
 * @property \DateTimeInterface $startdate Дата начала действия записи
 * @property \DateTimeInterface $enddate   Дата окончания действия записи
 */
final class NormativeDocsTypes extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string|null */
    protected $table = 'fias_laravel_normative_docs_types';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var array<int, string> */
    protected $fillable = [
        'id',
        'name',
        'startdate',
        'enddate',
    ];

    /** @var array */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
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
