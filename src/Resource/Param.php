<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'Param'.
 *
 * @property int                $id
 * @property int                $objectid
 * @property int|null           $changeid
 * @property int                $changeidend
 * @property int                $typeid
 * @property string             $value
 * @property \DateTimeInterface $updatedate
 * @property \DateTimeInterface $startdate
 * @property \DateTimeInterface $enddate
 */
class Param extends JsonResource
{
    /**
     * Преобразует сущность 'Param' в массив.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'objectid' => $this->objectid,
            'changeid' => $this->changeid,
            'changeidend' => $this->changeidend,
            'typeid' => $this->typeid,
            'value' => $this->value,
            'updatedate' => $this->updatedate->format(\DateTimeInterface::ATOM),
            'startdate' => $this->startdate->format(\DateTimeInterface::ATOM),
            'enddate' => $this->enddate->format(\DateTimeInterface::ATOM),
        ];
    }
}
