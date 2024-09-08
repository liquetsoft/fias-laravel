<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'HouseTypes'.
 *
 * @property int                $id
 * @property string             $name
 * @property string|null        $shortname
 * @property string|null        $desc
 * @property \DateTimeInterface $updatedate
 * @property \DateTimeInterface $startdate
 * @property \DateTimeInterface $enddate
 * @property string             $isactive
 */
class HouseTypes extends JsonResource
{
    /**
     * Преобразует сущность 'HouseTypes' в массив.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'shortname' => $this->shortname,
            'desc' => $this->desc,
            'updatedate' => $this->updatedate->format(\DateTimeInterface::ATOM),
            'startdate' => $this->startdate->format(\DateTimeInterface::ATOM),
            'enddate' => $this->enddate->format(\DateTimeInterface::ATOM),
            'isactive' => $this->isactive,
        ];
    }
}
