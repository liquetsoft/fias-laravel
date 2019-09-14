<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'CurrentStatus'.
 *
 * @property int    $curentstid
 * @property string $name
 */
class CurrentStatus extends JsonResource
{
    /**
     * Преобразует сущность 'CurrentStatus' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'curentstid' => $this->curentstid,
            'name' => $this->name,
        ];
    }
}
