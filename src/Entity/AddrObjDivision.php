<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по операциям переподчинения.
 *
 * @property int $id       Уникальный идентификатор записи. Ключевое поле
 * @property int $parentid Родительский ID
 * @property int $childid  Дочерний ID
 * @property int $changeid ID изменившей транзакции
 */
class AddrObjDivision extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_addr_obj_division';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string[] */
    protected $fillable = [
        'id',
        'parentid',
        'childid',
        'changeid',
    ];

    /** @var array */
    protected $casts = [
        'id' => 'integer',
        'parentid' => 'integer',
        'childid' => 'integer',
        'changeid' => 'integer',
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
