<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'OperationStatus'.
 *
 * @property int    $operstatid
 * @property string $name
 */
class OperationStatus extends JsonResource
{
    /**
     * Преобразует сущность 'OperationStatus' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'operstatid' => (int) $this->operstatid,
            'name' => (string) $this->name,
        ];
    }
}
