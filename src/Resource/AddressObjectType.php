<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'AddressObjectType'.
 */
class AddressObjectType extends JsonResource
{
    /**
     * Преобразует сущность 'AddressObjectType' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'kod_t_st' => $this->kod_t_st ?? null,
            'level' => $this->level ?? null,
            'socrname' => $this->socrname ?? null,
            'scname' => $this->scname ?? null,
        ];
    }
}
