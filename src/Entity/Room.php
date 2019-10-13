<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Сведения о помещениях (квартирах, офисах, комнатах и т.д.).
 *
 * @property string      $roomid
 * @property string|null $roomguid
 * @property string|null $houseguid
 * @property string      $regioncode
 * @property string      $flatnumber
 * @property int         $flattype
 * @property string|null $postalcode
 * @property Carbon      $startdate
 * @property Carbon      $enddate
 * @property Carbon      $updatedate
 * @property string      $operstatus
 * @property string      $livestatus
 * @property string|null $normdoc
 */
class Room extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'fias_laravel_room';

    /** @var string[] */
    protected $fillable = [
        'roomid',
        'roomguid',
        'houseguid',
        'regioncode',
        'flatnumber',
        'flattype',
        'postalcode',
        'startdate',
        'enddate',
        'updatedate',
        'operstatus',
        'livestatus',
        'normdoc',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'regioncode' => 'string',
        'flatnumber' => 'string',
        'flattype' => 'integer',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
        'updatedate' => 'datetime',
        'operstatus' => 'string',
        'livestatus' => 'string',
    ];

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}
