<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'ParamTypes'.
 *
 * @property int               $id
 * @property string            $name
 * @property string            $code
 * @property string|null       $desc
 * @property DateTimeInterface $updatedate
 * @property DateTimeInterface $startdate
 * @property DateTimeInterface $enddate
 * @property string            $isactive
 */
class ParamTypes extends JsonResource
{
    /**
     * Преобразует сущность 'ParamTypes' в массив.
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
            'code' => $this->code,
            'desc' => $this->desc,
            'updatedate' => $this->updatedate->format(DateTimeInterface::ATOM),
            'startdate' => $this->startdate->format(DateTimeInterface::ATOM),
            'enddate' => $this->enddate->format(DateTimeInterface::ATOM),
            'isactive' => $this->isactive,
        ];
    }
}
