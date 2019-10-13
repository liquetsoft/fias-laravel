<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Перечень типов комнат.
 *
 * @property int    $rmtypeid
 * @property string $name
 * @property string $shortname
 */
class RoomType extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'fias_laravel_room_type';

    /** @var string */
    protected $primaryKey = 'rmtypeid';

    /** @var string[] */
    protected $fillable = [
        'rmtypeid',
        'name',
        'shortname',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'rmtypeid' => 'integer',
        'name' => 'string',
        'shortname' => 'string',
    ];

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
