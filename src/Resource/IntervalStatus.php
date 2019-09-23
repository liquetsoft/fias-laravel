<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'IntervalStatus'.
 *
 * @property int    $intvstatid
 * @property string $name
 */
class IntervalStatus extends JsonResource
{
    /**
     * Преобразует сущность 'IntervalStatus' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'intvstatid' => (int) $this->intvstatid,
            'name' => (string) $this->name,
        ];
    }
}
