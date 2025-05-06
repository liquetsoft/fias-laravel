<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'AddrObjTypes'.
 *
 * @property int                $id
 * @property int                $level
 * @property string             $shortname
 * @property string             $name
 * @property string|null        $desc
 * @property \DateTimeInterface $updatedate
 * @property \DateTimeInterface $startdate
 * @property \DateTimeInterface $enddate
 * @property string             $isactive
 */
final class AddrObjTypes extends JsonResource
{
    /**
     * Преобразует сущность 'AddrObjTypes' в массив.
     *
     * @param Request $request
     */
    #[\Override]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'level' => $this->level,
            'shortname' => $this->shortname,
            'name' => $this->name,
            'desc' => $this->desc,
            'updatedate' => $this->updatedate->format(\DateTimeInterface::ATOM),
            'startdate' => $this->startdate->format(\DateTimeInterface::ATOM),
            'enddate' => $this->enddate->format(\DateTimeInterface::ATOM),
            'isactive' => $this->isactive,
        ];
    }
}
