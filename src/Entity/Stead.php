<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Сведения о земельных участках.
 *
 * @property string      $steadguid
 * @property string|null $number
 * @property string      $regioncode
 * @property string|null $postalcode
 * @property string      $ifnsfl
 * @property string      $ifnsul
 * @property string      $okato
 * @property string      $oktmo
 * @property string|null $parentguid
 * @property string|null $steadid
 * @property string      $operstatus
 * @property Carbon      $startdate
 * @property Carbon      $enddate
 * @property Carbon      $updatedate
 * @property string      $livestatus
 * @property string      $divtype
 * @property string|null $normdoc
 */
class Stead extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'fias_laravel_stead';

    /** @var string */
    protected $primaryKey = 'steadguid';

    /** @var string[] */
    protected $fillable = [
        'steadguid',
        'number',
        'regioncode',
        'postalcode',
        'ifnsfl',
        'ifnsul',
        'okato',
        'oktmo',
        'parentguid',
        'steadid',
        'operstatus',
        'startdate',
        'enddate',
        'updatedate',
        'livestatus',
        'divtype',
        'normdoc',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'regioncode' => 'string',
        'ifnsfl' => 'string',
        'ifnsul' => 'string',
        'okato' => 'string',
        'oktmo' => 'string',
        'operstatus' => 'string',
        'startdate' => 'datetime',
        'enddate' => 'datetime',
        'updatedate' => 'datetime',
        'livestatus' => 'string',
        'divtype' => 'string',
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
