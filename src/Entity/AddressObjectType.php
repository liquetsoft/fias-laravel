<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Перечень полных, сокращённых наименований типов адресных элементов и уровней их классификации.
 *
 * @property int         $kod_t_st
 * @property int         $level
 * @property string      $socrname
 * @property string|null $scname
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

    /** @var string[] */
    protected $fillable = [
        'kod_t_st',
        'level',
        'socrname',
        'scname',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'kod_t_st' => 'integer',
        'level' => 'integer',
        'socrname' => 'string',
        'scname' => 'string',
    ];
}
