<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'House'.
 *
 * @property string      $houseid
 * @property string|null $houseguid
 * @property string|null $aoguid
 * @property string      $housenum
 * @property int         $strstatus
 * @property int         $eststatus
 * @property int         $statstatus
 * @property string      $ifnsfl
 * @property string      $ifnsul
 * @property string      $okato
 * @property string      $oktmo
 * @property string      $postalcode
 * @property Carbon      $startdate
 * @property Carbon      $enddate
 * @property Carbon      $updatedate
 * @property int         $counter
 * @property int         $divtype
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
            'houseid' => $this->houseid,
            'houseguid' => $this->houseguid,
            'aoguid' => $this->aoguid,
            'housenum' => $this->housenum,
            'strstatus' => $this->strstatus,
            'eststatus' => $this->eststatus,
            'statstatus' => $this->statstatus,
            'ifnsfl' => $this->ifnsfl,
            'ifnsul' => $this->ifnsul,
            'okato' => $this->okato,
            'oktmo' => $this->oktmo,
            'postalcode' => $this->postalcode,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'updatedate' => $this->updatedate,
            'counter' => $this->counter,
            'divtype' => $this->divtype,
        ];
    }
}
