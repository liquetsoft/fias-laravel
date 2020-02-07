<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'House'.
 *
 * @property string            $houseid
 * @property string|null       $houseguid
 * @property string|null       $aoguid
 * @property string|null       $housenum
 * @property int               $strstatus
 * @property int               $eststatus
 * @property int               $statstatus
 * @property string|null       $ifnsfl
 * @property string|null       $ifnsul
 * @property string|null       $okato
 * @property string|null       $oktmo
 * @property string|null       $postalcode
 * @property DateTimeInterface $startdate
 * @property DateTimeInterface $enddate
 * @property DateTimeInterface $updatedate
 * @property int               $counter
 * @property int               $divtype
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
        return [
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
            'startdate' => $this->startdate->format('Y-m-d H:i:s'),
            'enddate' => $this->enddate->format('Y-m-d H:i:s'),
            'updatedate' => $this->updatedate->format('Y-m-d H:i:s'),
            'counter' => $this->counter,
            'divtype' => $this->divtype,
        ];
    }
}
