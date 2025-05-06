<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'ObjectLevels'.
 *
 * @property int                $level
 * @property string             $name
 * @property string|null        $shortname
 * @property \DateTimeInterface $updatedate
 * @property \DateTimeInterface $startdate
 * @property \DateTimeInterface $enddate
 * @property string             $isactive
 */
final class ObjectLevels extends JsonResource
{
    /**
     * Преобразует сущность 'ObjectLevels' в массив.
     *
     * @param Request $request
     */
    #[\Override]
    public function toArray($request): array
    {
        return [
            'level' => $this->level,
            'name' => $this->name,
            'shortname' => $this->shortname,
            'updatedate' => $this->updatedate->format(\DateTimeInterface::ATOM),
            'startdate' => $this->startdate->format(\DateTimeInterface::ATOM),
            'enddate' => $this->enddate->format(\DateTimeInterface::ATOM),
            'isactive' => $this->isactive,
        ];
    }
}
