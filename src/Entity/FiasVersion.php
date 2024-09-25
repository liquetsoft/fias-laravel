<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель, которая хранит историю версий ФИАС.
 *
 * @psalm-consistent-constructor
 *
 * @property int                $version    Номер версии ФИАС
 * @property string             $fullurl    Ссылка для загрузки полной версии ФИАС
 * @property string             $deltaurl   Ссылка для загрузки обновления до версии ФИАС
 * @property \DateTimeInterface $created_at Дата создания записи
 */
final class FiasVersion extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'fias_laravel_fias_version';
    protected $primaryKey = 'version';

    protected $fillable = [
        'version',
        'fullurl',
        'deltaurl',
        'created_at',
    ];

    protected $casts = [
        'version' => 'integer',
        'fullurl' => 'string',
        'deltaurl' => 'string',
        'created_at' => 'datetime',
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
