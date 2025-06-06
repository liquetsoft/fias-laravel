<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'Apartments'.
 *
 * @property int                $id
 * @property int                $objectid
 * @property string             $objectguid
 * @property int                $changeid
 * @property string             $number
 * @property int                $aparttype
 * @property int                $opertypeid
 * @property int|null           $previd
 * @property int|null           $nextid
 * @property \DateTimeInterface $updatedate
 * @property \DateTimeInterface $startdate
 * @property \DateTimeInterface $enddate
 * @property int                $isactual
 * @property int                $isactive
 */
final class Apartments extends JsonResource
{
    /**
     * Преобразует сущность 'Apartments' в массив.
     *
     * @param Request $request
     */
    #[\Override]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'objectid' => $this->objectid,
            'objectguid' => $this->objectguid,
            'changeid' => $this->changeid,
            'number' => $this->number,
            'aparttype' => $this->aparttype,
            'opertypeid' => $this->opertypeid,
            'previd' => $this->previd,
            'nextid' => $this->nextid,
            'updatedate' => $this->updatedate->format(\DateTimeInterface::ATOM),
            'startdate' => $this->startdate->format(\DateTimeInterface::ATOM),
            'enddate' => $this->enddate->format(\DateTimeInterface::ATOM),
            'isactual' => $this->isactual,
            'isactive' => $this->isactive,
        ];
    }
}
