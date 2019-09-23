<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'ActualStatus'.
 *
 * @property int    $actstatid
 * @property string $name
 */
class ActualStatus extends JsonResource
{
    /**
     * Преобразует сущность 'ActualStatus' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'actstatid' => (int) $this->actstatid,
            'name' => (string) $this->name,
        ];
    }
}
