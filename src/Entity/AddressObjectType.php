<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Перечень полных, сокращённых наименований типов адресных элементов и уровней их классификациих.
 *
 * @property int    $kod_t_st
 * @property int    $level
 * @property string $socrname
 * @property string $scname
 */
class AddressObjectType extends Model
{
    /** @var string */
    protected $table = 'fias_laravel_address_object_type';

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

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
