<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'Houses'.
 *
 * @property int                $id
 * @property int                $objectid
 * @property string             $objectguid
 * @property int                $changeid
 * @property string|null        $housenum
 * @property string|null        $addnum1
 * @property string|null        $addnum2
 * @property int|null           $housetype
 * @property int|null           $addtype1
 * @property int|null           $addtype2
 * @property int                $opertypeid
 * @property int|null           $previd
 * @property int|null           $nextid
 * @property \DateTimeInterface $updatedate
 * @property \DateTimeInterface $startdate
 * @property \DateTimeInterface $enddate
 * @property int                $isactual
 * @property int                $isactive
 */
class Houses extends JsonResource
{
    /**
     * Преобразует сущность 'Houses' в массив.
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
            'housenum' => $this->housenum,
            'addnum1' => $this->addnum1,
            'addnum2' => $this->addnum2,
            'housetype' => $this->housetype,
            'addtype1' => $this->addtype1,
            'addtype2' => $this->addtype2,
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
