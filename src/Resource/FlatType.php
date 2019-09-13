<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'FlatType'.
 */
class FlatType extends JsonResource
{
    /**
     * Преобразует сущность 'FlatType' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'fltypeid' => $this->fltypeid ?? null,
            'name' => $this->name ?? null,
            'shortname' => $this->shortname ?? null,
        ];
    }
}
