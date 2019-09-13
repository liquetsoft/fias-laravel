<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'CenterStatus'.
 *
 * @property int    $centerstid
 * @property string $name
 */
class CenterStatus extends JsonResource
{
    /**
     * Преобразует сущность 'CenterStatus' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'centerstid' => $this->centerstid,
            'name' => $this->name,
        ];
    }
}
