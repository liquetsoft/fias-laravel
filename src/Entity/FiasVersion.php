<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель, которая хранит историю версий ФИАС.
 *
 * @property int    $version
 * @property string $url
 * @property string $created_at
 */
class FiasVersion extends Model
{
    /** @var string */
    protected $table = 'fias_laravel_fias_version';

    /** @var string[] */
    protected $fillable = [
        'version',
        'url',
        'created_at',
    ];

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
