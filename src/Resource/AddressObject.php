<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'AddressObject'.
 */
class AddressObject extends JsonResource
{
    /**
     * Преобразует сущность 'AddressObject' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'aoid' => $this->aoid ?? null,
            'aoguid' => $this->aoguid ?? null,
            'parentguid' => $this->parentguid ?? null,
            'previd' => $this->previd ?? null,
            'nextid' => $this->nextid ?? null,
            'code' => $this->code ?? null,
            'formalname' => $this->formalname ?? null,
            'offname' => $this->offname ?? null,
            'shortname' => $this->shortname ?? null,
            'aolevel' => $this->aolevel ?? null,
            'regioncode' => $this->regioncode ?? null,
            'areacode' => $this->areacode ?? null,
            'autocode' => $this->autocode ?? null,
            'citycode' => $this->citycode ?? null,
            'ctarcode' => $this->ctarcode ?? null,
            'placecode' => $this->placecode ?? null,
            'plancode' => $this->plancode ?? null,
            'streetcode' => $this->streetcode ?? null,
            'extrcode' => $this->extrcode ?? null,
            'sextcode' => $this->sextcode ?? null,
            'plaincode' => $this->plaincode ?? null,
            'currstatus' => $this->currstatus ?? null,
            'actstatus' => $this->actstatus ?? null,
            'livestatus' => $this->livestatus ?? null,
            'centstatus' => $this->centstatus ?? null,
            'operstatus' => $this->operstatus ?? null,
            'ifnsfl' => $this->ifnsfl ?? null,
            'ifnsul' => $this->ifnsul ?? null,
            'terrifnsfl' => $this->terrifnsfl ?? null,
            'terrifnsul' => $this->terrifnsul ?? null,
            'okato' => $this->okato ?? null,
            'oktmo' => $this->oktmo ?? null,
            'postalcode' => $this->postalcode ?? null,
            'startdate' => $this->startdate ?? null,
            'enddate' => $this->enddate ?? null,
            'updatedate' => $this->updatedate ?? null,
            'divtype' => $this->divtype ?? null,
        ];
    }
}
