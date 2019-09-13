<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'ActualStatus'.
 */
class ActualStatus extends JsonResource
{
    /**
     * Преобразует сущность 'ActualStatus' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'actstatid' => $this->actstatid ?? null,
            'name' => $this->name ?? null,
        ];
    }
}
