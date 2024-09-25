<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по видам нормативных документов.
 *
 * @psalm-consistent-constructor
 *
 * @property int    $id   Идентификатор записи
 * @property string $name Наименование
 */
final class NormativeDocsKinds extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'fias_laravel_normative_docs_kinds';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
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
