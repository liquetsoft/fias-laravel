<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'Stead'.
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
class Stead extends JsonResource
{
    /**
     * Преобразует сущность 'Stead' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'steadguid' => $this->steadguid,
            'number' => $this->number,
            'regioncode' => $this->regioncode,
            'postalcode' => $this->postalcode,
            'ifnsfl' => $this->ifnsfl,
            'ifnsul' => $this->ifnsul,
            'okato' => $this->okato,
            'oktmo' => $this->oktmo,
            'parentguid' => $this->parentguid,
            'steadid' => $this->steadid,
            'operstatus' => $this->operstatus,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'updatedate' => $this->updatedate,
            'livestatus' => $this->livestatus,
            'divtype' => $this->divtype,
            'normdoc' => $this->normdoc,
        ];
    }
}
