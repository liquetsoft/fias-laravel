<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'OperationStatus'.
 */
class OperationStatus extends JsonResource
{
    /**
     * Преобразует сущность 'OperationStatus' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'operstatid' => $this->operstatid ?? null,
            'name' => $this->name ?? null,
        ];
    }
}
