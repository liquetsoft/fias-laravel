<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Сведения о земельных участках.
 *
 * @property string      $steadguid
 * @property string      $number
 * @property string      $regioncode
 * @property string      $postalcode
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
    /** @var string */
    protected $table = 'fias_laravel_stead';

    /** @var string[] */
    protected $fillable = [
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

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
