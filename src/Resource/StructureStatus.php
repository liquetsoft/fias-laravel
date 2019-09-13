<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'StructureStatus'.
 */
class StructureStatus extends JsonResource
{
    /**
     * Преобразует сущность 'StructureStatus' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'strstatid' => $this->strstatid ?? null,
            'name' => $this->name ?? null,
            'shortname' => $this->shortname ?? null,
        ];
    }
}
