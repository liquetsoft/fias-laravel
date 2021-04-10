<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Тип адресного объекта.
 *
 * @property string      $kod_t_st Ключевое поле
 * @property int         $level    Уровень адресного объекта
 * @property string      $socrname Полное наименование типа объекта
 * @property string|null $scname   Краткое наименование типа объекта
 */
class AddressObjectType extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_address_object_type';

    /** @var string */
    protected $primaryKey = 'kod_t_st';

    /** @var string */
    protected $keyType = 'string';

    /** @var string[] */
    protected $fillable = [
        'kod_t_st',
        'level',
        'socrname',
        'scname',
    ];

    /** @var array */
    protected $casts = [
        'kod_t_st' => 'string',
        'level' => 'integer',
        'socrname' => 'string',
        'scname' => 'string',
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
