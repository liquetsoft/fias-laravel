<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'AdmHierarchy'.
 *
 * @property int               $id
 * @property int               $objectid
 * @property int|null          $parentobjid
 * @property int               $changeid
 * @property string|null       $regioncode
 * @property string|null       $areacode
 * @property string|null       $citycode
 * @property string|null       $placecode
 * @property string|null       $plancode
 * @property string|null       $streetcode
 * @property int|null          $previd
 * @property int|null          $nextid
 * @property DateTimeInterface $updatedate
 * @property DateTimeInterface $startdate
 * @property DateTimeInterface $enddate
 * @property int               $isactive
 */
class AdmHierarchy extends JsonResource
{
    /**
     * Преобразует сущность 'AdmHierarchy' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'objectid' => $this->objectid,
            'parentobjid' => $this->parentobjid,
            'changeid' => $this->changeid,
            'regioncode' => $this->regioncode,
            'areacode' => $this->areacode,
            'citycode' => $this->citycode,
            'placecode' => $this->placecode,
            'plancode' => $this->plancode,
            'streetcode' => $this->streetcode,
            'previd' => $this->previd,
            'nextid' => $this->nextid,
            'updatedate' => $this->updatedate->format(DateTimeInterface::ATOM),
            'startdate' => $this->startdate->format(DateTimeInterface::ATOM),
            'enddate' => $this->enddate->format(DateTimeInterface::ATOM),
            'isactive' => $this->isactive,
        ];
    }
}
