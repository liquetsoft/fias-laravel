<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'Room'.
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
            'roomid' => $this->roomid ?? null,
            'roomguid' => $this->roomguid ?? null,
            'houseguid' => $this->houseguid ?? null,
            'regioncode' => $this->regioncode ?? null,
            'flatnumber' => $this->flatnumber ?? null,
            'flattype' => $this->flattype ?? null,
            'postalcode' => $this->postalcode ?? null,
            'startdate' => $this->startdate ?? null,
            'enddate' => $this->enddate ?? null,
            'updatedate' => $this->updatedate ?? null,
            'operstatus' => $this->operstatus ?? null,
            'livestatus' => $this->livestatus ?? null,
            'normdoc' => $this->normdoc ?? null,
        ];
    }
}
