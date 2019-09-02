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
 * @property string      $postalcode
 * @property Carbon      $startdate
 * @property Carbon      $enddate
 * @property Carbon      $updatedate
 * @property string      $operstatus
 * @property string      $livestatus
 * @property string|null $normdoc
 */
class Room extends Model
{
    /** @var string */
    protected $table = 'fias_laravel_room';

    /** @var string[] */
    protected $fillable = [
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

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
