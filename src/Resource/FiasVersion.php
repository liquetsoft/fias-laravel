<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'FiasVersion'.
 */
class FiasVersion extends JsonResource
{
    /**
     * Преобразует сущность 'FiasVersion' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'version' => $this->version ?? null,
            'url' => $this->url ?? null,
            'created_at' => $this->created_at ?? null,
        ];
    }
}
