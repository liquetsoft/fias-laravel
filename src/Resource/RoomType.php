<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'RoomType'.
 */
class RoomType extends JsonResource
{
    /**
     * Преобразует сущность 'RoomType' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'rmtypeid' => $this->rmtypeid ?? null,
            'name' => $this->name ?? null,
            'shortname' => $this->shortname ?? null,
        ];
    }
}
