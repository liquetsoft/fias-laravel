<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'Room'.
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
class Room extends JsonResource
{
    /**
     * Преобразует сущность 'Room' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'roomid' => $this->roomid,
            'roomguid' => $this->roomguid,
            'houseguid' => $this->houseguid,
            'regioncode' => $this->regioncode,
            'flatnumber' => $this->flatnumber,
            'flattype' => $this->flattype,
            'postalcode' => $this->postalcode,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'updatedate' => $this->updatedate,
            'operstatus' => $this->operstatus,
            'livestatus' => $this->livestatus,
            'normdoc' => $this->normdoc,
        ];
    }
}
