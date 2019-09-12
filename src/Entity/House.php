<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Элементы адреса, идентифицирующие адресуемые объекты.
 *
 * @property string      $houseid
 * @property string|null $houseguid
 * @property string|null $aoguid
 * @property string      $housenum
 * @property int         $strstatus
 * @property int         $eststatus
 * @property int         $statstatus
 * @property string      $ifnsfl
 * @property string      $ifnsul
 * @property string      $okato
 * @property string      $oktmo
 * @property string      $postalcode
 * @property Carbon      $startdate
 * @property Carbon      $enddate
 * @property Carbon      $updatedate
 * @property int         $counter
 * @property int         $divtype
 */
class House extends Model
{
    /** @var string */
    protected $table = 'fias_laravel_house';

    /** @var string[] */
    protected $fillable = [
        'houseid',
        'houseguid',
        'aoguid',
        'housenum',
        'strstatus',
        'eststatus',
        'statstatus',
        'ifnsfl',
        'ifnsul',
        'okato',
        'oktmo',
        'postalcode',
        'startdate',
        'enddate',
        'updatedate',
        'counter',
        'divtype',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'housenum' => 'string',
        'strstatus' => 'integer',
        'eststatus' => 'integer',
        'statstatus' => 'integer',
        'ifnsfl' => 'string',
        'ifnsul' => 'string',
        'okato' => 'string',
        'oktmo' => 'string',
        'postalcode' => 'string',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
        'updatedate' => 'datetime',
        'counter' => 'integer',
        'divtype' => 'integer',
    ];

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
