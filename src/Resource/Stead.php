<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'Stead'.
 *
 * @property string                   $steadguid
 * @property string                   $number
 * @property string                   $regioncode
 * @property string                   $postalcode
 * @property string                   $ifnsfl
 * @property string                   $ifnsul
 * @property string                   $okato
 * @property string                   $oktmo
 * @property string|null              $parentguid
 * @property string|null              $steadid
 * @property string                   $operstatus
 * @property DateTimeInterface|string $startdate
 * @property DateTimeInterface|string $enddate
 * @property DateTimeInterface|string $updatedate
 * @property string                   $livestatus
 * @property string                   $divtype
 * @property string|null              $normdoc
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
            'steadguid' => (string) $this->steadguid,
            'number' => (string) $this->number,
            'regioncode' => (string) $this->regioncode,
            'postalcode' => (string) $this->postalcode,
            'ifnsfl' => (string) $this->ifnsfl,
            'ifnsul' => (string) $this->ifnsul,
            'okato' => (string) $this->okato,
            'oktmo' => (string) $this->oktmo,
            'parentguid' => (string) $this->parentguid,
            'steadid' => (string) $this->steadid,
            'operstatus' => (string) $this->operstatus,
            'startdate' => $this->startdate instanceof DateTimeInterface ? $this->startdate->format('Y-m-d H:i:s') : (string) $this->startdate,
            'enddate' => $this->enddate instanceof DateTimeInterface ? $this->enddate->format('Y-m-d H:i:s') : (string) $this->enddate,
            'updatedate' => $this->updatedate instanceof DateTimeInterface ? $this->updatedate->format('Y-m-d H:i:s') : (string) $this->updatedate,
            'livestatus' => (string) $this->livestatus,
            'divtype' => (string) $this->divtype,
            'normdoc' => (string) $this->normdoc,
        ];
    }
}
