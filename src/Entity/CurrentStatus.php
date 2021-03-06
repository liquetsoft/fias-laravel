<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Статус актуальности КЛАДР 4.0.
 *
 * @property int    $curentstid Идентификатор статуса (ключ)
 * @property string $name       Наименование (0 - актуальный, 1-50, 2-98 – исторический (кроме 51), 51 - переподчиненный, 99 - несуществующий)
 */
class CurrentStatus extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_current_status';

    /** @var string */
    protected $primaryKey = 'curentstid';

    /** @var string[] */
    protected $fillable = [
        'curentstid',
        'name',
    ];

    /** @var array */
    protected $casts = [
        'curentstid' => 'integer',
        'name' => 'string',
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
