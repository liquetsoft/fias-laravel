<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по видам нормативных документов.
 *
 * @property int    $id   Идентификатор записи
 * @property string $name Наименование
 */
class NormativeDocsKinds extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_normative_docs_kinds';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'name',
    ];

    /** @var array */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
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
