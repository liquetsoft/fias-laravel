<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'AddrObj'.
 *
 * @property int                $id
 * @property int                $objectid
 * @property string             $objectguid
 * @property int                $changeid
 * @property string             $name
 * @property string             $typename
 * @property string             $level
 * @property int                $opertypeid
 * @property int|null           $previd
 * @property int|null           $nextid
 * @property \DateTimeInterface $updatedate
 * @property \DateTimeInterface $startdate
 * @property \DateTimeInterface $enddate
 * @property int                $isactual
 * @property int                $isactive
 */
class AddrObj extends JsonResource
{
    /**
     * Преобразует сущность 'AddrObj' в массив.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'objectid' => $this->objectid,
            'objectguid' => $this->objectguid,
            'changeid' => $this->changeid,
            'name' => $this->name,
            'typename' => $this->typename,
            'level' => $this->level,
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
