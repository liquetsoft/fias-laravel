<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'AddressObjectType'.
 *
 * @property int    $kod_t_st
 * @property int    $level
 * @property string $socrname
 * @property string $scname
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
        return [
            'kod_t_st' => (int) $this->kod_t_st,
            'level' => (int) $this->level,
            'socrname' => (string) $this->socrname,
            'scname' => (string) $this->scname,
        ];
    }
}
