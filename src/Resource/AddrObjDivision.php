<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'AddrObjDivision'.
 *
 * @property int $id
 * @property int $parentid
 * @property int $childid
 * @property int $changeid
 */
final class AddrObjDivision extends JsonResource
{
    /**
     * Преобразует сущность 'AddrObjDivision' в массив.
     *
     * @param Request $request
     */
    #[\Override]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'parentid' => $this->parentid,
            'childid' => $this->childid,
            'changeid' => $this->changeid,
        ];
    }
}
