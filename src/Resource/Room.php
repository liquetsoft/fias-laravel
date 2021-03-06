<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'Room'.
 *
 * @property string            $roomid
 * @property string            $roomguid
 * @property string            $houseguid
 * @property string            $regioncode
 * @property string            $flatnumber
 * @property int               $flattype
 * @property string|null       $postalcode
 * @property DateTimeInterface $startdate
 * @property DateTimeInterface $enddate
 * @property DateTimeInterface $updatedate
 * @property int               $operstatus
 * @property int               $livestatus
 * @property string|null       $normdoc
 * @property string|null       $roomnumber
 * @property int|null          $roomtype
 * @property string|null       $previd
 * @property string|null       $nextid
 * @property string|null       $cadnum
 * @property string|null       $roomcadnum
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
        return [
            'roomid' => $this->roomid,
            'roomguid' => $this->roomguid,
            'houseguid' => $this->houseguid,
            'regioncode' => $this->regioncode,
            'flatnumber' => $this->flatnumber,
            'flattype' => $this->flattype,
            'postalcode' => $this->postalcode,
            'startdate' => $this->startdate->format(DateTimeInterface::ATOM),
            'enddate' => $this->enddate->format(DateTimeInterface::ATOM),
            'updatedate' => $this->updatedate->format(DateTimeInterface::ATOM),
            'operstatus' => $this->operstatus,
            'livestatus' => $this->livestatus,
            'normdoc' => $this->normdoc,
            'roomnumber' => $this->roomnumber,
            'roomtype' => $this->roomtype,
            'previd' => $this->previd,
            'nextid' => $this->nextid,
            'cadnum' => $this->cadnum,
            'roomcadnum' => $this->roomcadnum,
        ];
    }
}
