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
 * @property string|null $housenum
 * @property int         $strstatus
 * @property int         $eststatus
 * @property int         $statstatus
 * @property string|null $ifnsfl
 * @property string|null $ifnsul
 * @property string|null $okato
 * @property string|null $oktmo
 * @property string|null $postalcode
 * @property Carbon      $startdate
 * @property Carbon      $enddate
 * @property Carbon      $updatedate
 * @property int         $counter
 * @property int         $divtype
 */
class House extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_house';

    /** @var string */
    protected $primaryKey = 'houseid';

    /** @var string */
    protected $keyType = 'string';

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
        'houseid' => 'string',
        'houseguid' => 'string',
        'aoguid' => 'string',
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
}
