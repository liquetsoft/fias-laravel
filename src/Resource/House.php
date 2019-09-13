<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'House'.
 */
class House extends JsonResource
{
    /**
     * Преобразует сущность 'House' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'houseid' => $this->houseid ?? null,
            'houseguid' => $this->houseguid ?? null,
            'aoguid' => $this->aoguid ?? null,
            'housenum' => $this->housenum ?? null,
            'strstatus' => $this->strstatus ?? null,
            'eststatus' => $this->eststatus ?? null,
            'statstatus' => $this->statstatus ?? null,
            'ifnsfl' => $this->ifnsfl ?? null,
            'ifnsul' => $this->ifnsul ?? null,
            'okato' => $this->okato ?? null,
            'oktmo' => $this->oktmo ?? null,
            'postalcode' => $this->postalcode ?? null,
            'startdate' => $this->startdate ?? null,
            'enddate' => $this->enddate ?? null,
            'updatedate' => $this->updatedate ?? null,
            'counter' => $this->counter ?? null,
            'divtype' => $this->divtype ?? null,
        ];
    }
}
