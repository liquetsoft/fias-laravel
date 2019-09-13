<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'HouseStateStatus'.
 *
 * @property int    $housestid
 * @property string $name
 */
class HouseStateStatus extends JsonResource
{
    /**
     * Преобразует сущность 'HouseStateStatus' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'housestid' => $this->housestid,
            'name' => $this->name,
        ];
    }
}
