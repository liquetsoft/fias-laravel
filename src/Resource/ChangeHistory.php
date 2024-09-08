<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'ChangeHistory'.
 *
 * @property int                $changeid
 * @property int                $objectid
 * @property string             $adrobjectid
 * @property int                $opertypeid
 * @property int|null           $ndocid
 * @property \DateTimeInterface $changedate
 */
class ChangeHistory extends JsonResource
{
    /**
     * Преобразует сущность 'ChangeHistory' в массив.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'changeid' => $this->changeid,
            'objectid' => $this->objectid,
            'adrobjectid' => $this->adrobjectid,
            'opertypeid' => $this->opertypeid,
            'ndocid' => $this->ndocid,
            'changedate' => $this->changedate->format(\DateTimeInterface::ATOM),
        ];
    }
}
