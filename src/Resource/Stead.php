<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'Stead'.
 *
 * @property string            $steadguid
 * @property string|null       $number
 * @property string            $regioncode
 * @property string|null       $postalcode
 * @property string|null       $ifnsfl
 * @property string|null       $ifnsul
 * @property string|null       $okato
 * @property string|null       $oktmo
 * @property string|null       $parentguid
 * @property string            $steadid
 * @property int               $operstatus
 * @property DateTimeInterface $startdate
 * @property DateTimeInterface $enddate
 * @property DateTimeInterface $updatedate
 * @property int               $livestatus
 * @property int               $divtype
 * @property string|null       $normdoc
 * @property string|null       $terrifnsfl
 * @property string|null       $terrifnsul
 * @property string|null       $previd
 * @property string|null       $nextid
 * @property string|null       $cadnum
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
        return [
            'steadguid' => $this->steadguid,
            'number' => $this->number,
            'regioncode' => $this->regioncode,
            'postalcode' => $this->postalcode,
            'ifnsfl' => $this->ifnsfl,
            'ifnsul' => $this->ifnsul,
            'okato' => $this->okato,
            'oktmo' => $this->oktmo,
            'parentguid' => $this->parentguid,
            'steadid' => $this->steadid,
            'operstatus' => $this->operstatus,
            'startdate' => $this->startdate->format(DateTimeInterface::ATOM),
            'enddate' => $this->enddate->format(DateTimeInterface::ATOM),
            'updatedate' => $this->updatedate->format(DateTimeInterface::ATOM),
            'livestatus' => $this->livestatus,
            'divtype' => $this->divtype,
            'normdoc' => $this->normdoc,
            'terrifnsfl' => $this->terrifnsfl,
            'terrifnsul' => $this->terrifnsul,
            'previd' => $this->previd,
            'nextid' => $this->nextid,
            'cadnum' => $this->cadnum,
        ];
    }
}
