<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'MunHierarchy'.
 *
 * @property int                $id
 * @property int                $objectid
 * @property int|null           $parentobjid
 * @property int                $changeid
 * @property string|null        $oktmo
 * @property int|null           $previd
 * @property int|null           $nextid
 * @property \DateTimeInterface $updatedate
 * @property \DateTimeInterface $startdate
 * @property \DateTimeInterface $enddate
 * @property int                $isactive
 * @property string             $path
 */
class MunHierarchy extends JsonResource
{
    /**
     * Преобразует сущность 'MunHierarchy' в массив.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'objectid' => $this->objectid,
            'parentobjid' => $this->parentobjid,
            'changeid' => $this->changeid,
            'oktmo' => $this->oktmo,
            'previd' => $this->previd,
            'nextid' => $this->nextid,
            'updatedate' => $this->updatedate->format(\DateTimeInterface::ATOM),
            'startdate' => $this->startdate->format(\DateTimeInterface::ATOM),
            'enddate' => $this->enddate->format(\DateTimeInterface::ATOM),
            'isactive' => $this->isactive,
            'path' => $this->path,
        ];
    }
}
