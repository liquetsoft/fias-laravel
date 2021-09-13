<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'NormativeDocsTypes'.
 *
 * @property int               $id
 * @property string            $name
 * @property DateTimeInterface $startdate
 * @property DateTimeInterface $enddate
 */
class NormativeDocsTypes extends JsonResource
{
    /**
     * Преобразует сущность 'NormativeDocsTypes' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'startdate' => $this->startdate->format(DateTimeInterface::ATOM),
            'enddate' => $this->enddate->format(DateTimeInterface::ATOM),
        ];
    }
}
