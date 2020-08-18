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
 * @property string            $houseguid
 * @property string            $aoguid
 * @property string|null       $housenum
 * @property int|null          $strstatus
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
 * @property string|null       $regioncode
 * @property string|null       $terrifnsfl
 * @property string|null       $terrifnsul
 * @property string|null       $buildnum
 * @property string|null       $strucnum
 * @property string|null       $normdoc
 * @property string|null       $cadnum
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
            'startdate' => $this->startdate->format(DateTimeInterface::ATOM),
            'enddate' => $this->enddate->format(DateTimeInterface::ATOM),
            'updatedate' => $this->updatedate->format(DateTimeInterface::ATOM),
            'counter' => $this->counter,
            'divtype' => $this->divtype,
            'regioncode' => $this->regioncode,
            'terrifnsfl' => $this->terrifnsfl,
            'terrifnsul' => $this->terrifnsul,
            'buildnum' => $this->buildnum,
            'strucnum' => $this->strucnum,
            'normdoc' => $this->normdoc,
            'cadnum' => $this->cadnum,
        ];
    }
}
