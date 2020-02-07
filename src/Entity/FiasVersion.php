<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель, которая хранит историю версий ФИАС.
 *
 * @property int    $version    Номер версии ФИАС
 * @property string $url        Ссылка для загрузки указанной версии ФИАС
 * @property string $created_at Дата создания записи
 */
class FiasVersion extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_fias_version';

    /** @var string */
    protected $primaryKey = 'version';

    /** @var string[] */
    protected $fillable = [
        'version',
        'url',
        'created_at',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'version' => 'integer',
        'url' => 'string',
    ];
}
