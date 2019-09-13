<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'Stead'.
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
        return[
            'steadguid' => $this->steadguid ?? null,
            'number' => $this->number ?? null,
            'regioncode' => $this->regioncode ?? null,
            'postalcode' => $this->postalcode ?? null,
            'ifnsfl' => $this->ifnsfl ?? null,
            'ifnsul' => $this->ifnsul ?? null,
            'okato' => $this->okato ?? null,
            'oktmo' => $this->oktmo ?? null,
            'parentguid' => $this->parentguid ?? null,
            'steadid' => $this->steadid ?? null,
            'operstatus' => $this->operstatus ?? null,
            'startdate' => $this->startdate ?? null,
            'enddate' => $this->enddate ?? null,
            'updatedate' => $this->updatedate ?? null,
            'livestatus' => $this->livestatus ?? null,
            'divtype' => $this->divtype ?? null,
            'normdoc' => $this->normdoc ?? null,
        ];
    }
}
