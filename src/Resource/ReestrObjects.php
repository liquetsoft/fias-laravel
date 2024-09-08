<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'ReestrObjects'.
 *
 * @property int                $objectid
 * @property \DateTimeInterface $createdate
 * @property int                $changeid
 * @property int                $levelid
 * @property \DateTimeInterface $updatedate
 * @property string             $objectguid
 * @property int                $isactive
 */
class ReestrObjects extends JsonResource
{
    /**
     * Преобразует сущность 'ReestrObjects' в массив.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'objectid' => $this->objectid,
            'createdate' => $this->createdate->format(\DateTimeInterface::ATOM),
            'changeid' => $this->changeid,
            'levelid' => $this->levelid,
            'updatedate' => $this->updatedate->format(\DateTimeInterface::ATOM),
            'objectguid' => $this->objectguid,
            'isactive' => $this->isactive,
        ];
    }
}
