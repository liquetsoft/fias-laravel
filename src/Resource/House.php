<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'House'.
 *
 * @property string                   $houseid
 * @property string|null              $houseguid
 * @property string|null              $aoguid
 * @property string                   $housenum
 * @property int                      $strstatus
 * @property int                      $eststatus
 * @property int                      $statstatus
 * @property string                   $ifnsfl
 * @property string                   $ifnsul
 * @property string                   $okato
 * @property string                   $oktmo
 * @property string                   $postalcode
 * @property DateTimeInterface|string $startdate
 * @property DateTimeInterface|string $enddate
 * @property DateTimeInterface|string $updatedate
 * @property int                      $counter
 * @property int                      $divtype
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
            'houseid' => (string) $this->houseid,
            'houseguid' => (string) $this->houseguid,
            'aoguid' => (string) $this->aoguid,
            'housenum' => (string) $this->housenum,
            'strstatus' => (int) $this->strstatus,
            'eststatus' => (int) $this->eststatus,
            'statstatus' => (int) $this->statstatus,
            'ifnsfl' => (string) $this->ifnsfl,
            'ifnsul' => (string) $this->ifnsul,
            'okato' => (string) $this->okato,
            'oktmo' => (string) $this->oktmo,
            'postalcode' => (string) $this->postalcode,
            'startdate' => $this->startdate instanceof DateTimeInterface ? $this->startdate->format('Y-m-d H:i:s') : (string) $this->startdate,
            'enddate' => $this->enddate instanceof DateTimeInterface ? $this->enddate->format('Y-m-d H:i:s') : (string) $this->enddate,
            'updatedate' => $this->updatedate instanceof DateTimeInterface ? $this->updatedate->format('Y-m-d H:i:s') : (string) $this->updatedate,
            'counter' => (int) $this->counter,
            'divtype' => (int) $this->divtype,
        ];
    }
}
