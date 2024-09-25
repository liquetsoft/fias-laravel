<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по операциям переподчинения.
 *
 * @psalm-consistent-constructor
 *
 * @property int $id       Уникальный идентификатор записи. Ключевое поле
 * @property int $parentid Родительский ID
 * @property int $childid  Дочерний ID
 * @property int $changeid ID изменившей транзакции
 */
final class AddrObjDivision extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'fias_laravel_addr_obj_division';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'parentid',
        'childid',
        'changeid',
    ];

    protected $casts = [
        'id' => 'integer',
        'parentid' => 'integer',
        'childid' => 'integer',
        'changeid' => 'integer',
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
