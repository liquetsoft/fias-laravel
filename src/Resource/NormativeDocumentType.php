<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'NormativeDocumentType'.
 */
class NormativeDocumentType extends JsonResource
{
    /**
     * Преобразует сущность 'NormativeDocumentType' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'ndtypeid' => $this->ndtypeid ?? null,
            'name' => $this->name ?? null,
        ];
    }
}
