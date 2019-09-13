<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Реестр адресообразующих элементов.
 *
 * @property string      $aoid
 * @property string|null $aoguid
 * @property string|null $parentguid
 * @property string|null $previd
 * @property string|null $nextid
 * @property string|null $code
 * @property string      $formalname
 * @property string      $offname
 * @property string      $shortname
 * @property int         $aolevel
 * @property string      $regioncode
 * @property string      $areacode
 * @property string      $autocode
 * @property string      $citycode
 * @property string      $ctarcode
 * @property string      $placecode
 * @property string      $plancode
 * @property string      $streetcode
 * @property string      $extrcode
 * @property string      $sextcode
 * @property string      $plaincode
 * @property int         $currstatus
 * @property int         $actstatus
 * @property int         $livestatus
 * @property int         $centstatus
 * @property int         $operstatus
 * @property string      $ifnsfl
 * @property string      $ifnsul
 * @property string      $terrifnsfl
 * @property string      $terrifnsul
 * @property string      $okato
 * @property string      $oktmo
 * @property string      $postalcode
 * @property Carbon      $startdate
 * @property Carbon      $enddate
 * @property Carbon      $updatedate
 * @property int         $divtype
 */
class AddressObject extends Model
{
    /** @var string */
    protected $table = 'fias_laravel_address_object';

    /** @var string[] */
    protected $fillable = [
        'aoid',
        'aoguid',
        'parentguid',
        'previd',
        'nextid',
        'code',
        'formalname',
        'offname',
        'shortname',
        'aolevel',
        'regioncode',
        'areacode',
        'autocode',
        'citycode',
        'ctarcode',
        'placecode',
        'plancode',
        'streetcode',
        'extrcode',
        'sextcode',
        'plaincode',
        'currstatus',
        'actstatus',
        'livestatus',
        'centstatus',
        'operstatus',
        'ifnsfl',
        'ifnsul',
        'terrifnsfl',
        'terrifnsul',
        'okato',
        'oktmo',
        'postalcode',
        'startdate',
        'enddate',
        'updatedate',
        'divtype',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'formalname' => 'string',
        'offname' => 'string',
        'shortname' => 'string',
        'aolevel' => 'integer',
        'regioncode' => 'string',
        'areacode' => 'string',
        'autocode' => 'string',
        'citycode' => 'string',
        'ctarcode' => 'string',
        'placecode' => 'string',
        'plancode' => 'string',
        'streetcode' => 'string',
        'extrcode' => 'string',
        'sextcode' => 'string',
        'plaincode' => 'string',
        'currstatus' => 'integer',
        'actstatus' => 'integer',
        'livestatus' => 'integer',
        'centstatus' => 'integer',
        'operstatus' => 'integer',
        'ifnsfl' => 'string',
        'ifnsul' => 'string',
        'terrifnsfl' => 'string',
        'terrifnsul' => 'string',
        'okato' => 'string',
        'oktmo' => 'string',
        'postalcode' => 'string',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
        'updatedate' => 'datetime',
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
