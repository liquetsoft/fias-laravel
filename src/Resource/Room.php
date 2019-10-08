<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'Room'.
 *
 * @property string                   $roomid
 * @property string|null              $roomguid
 * @property string|null              $houseguid
 * @property string                   $regioncode
 * @property string                   $flatnumber
 * @property int                      $flattype
 * @property string|null              $postalcode
 * @property DateTimeInterface|string $startdate
 * @property DateTimeInterface|string $enddate
 * @property DateTimeInterface|string $updatedate
 * @property string                   $operstatus
 * @property string                   $livestatus
 * @property string|null              $normdoc
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
            'roomid' => (string) $this->roomid,
            'roomguid' => (string) $this->roomguid,
            'houseguid' => (string) $this->houseguid,
            'regioncode' => (string) $this->regioncode,
            'flatnumber' => (string) $this->flatnumber,
            'flattype' => (int) $this->flattype,
            'postalcode' => (string) $this->postalcode,
            'startdate' => $this->startdate instanceof DateTimeInterface ? $this->startdate->format('Y-m-d H:i:s') : (string) $this->startdate,
            'enddate' => $this->enddate instanceof DateTimeInterface ? $this->enddate->format('Y-m-d H:i:s') : (string) $this->enddate,
            'updatedate' => $this->updatedate instanceof DateTimeInterface ? $this->updatedate->format('Y-m-d H:i:s') : (string) $this->updatedate,
            'operstatus' => (string) $this->operstatus,
            'livestatus' => (string) $this->livestatus,
            'normdoc' => (string) $this->normdoc,
        ];
    }
}
