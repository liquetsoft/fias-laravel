<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'EstateStatus'.
 */
class EstateStatus extends JsonResource
{
    /**
     * Преобразует сущность 'EstateStatus' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'eststatid' => $this->eststatid ?? null,
            'name' => $this->name ?? null,
        ];
    }
}
