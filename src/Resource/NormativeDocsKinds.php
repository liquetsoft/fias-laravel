<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'NormativeDocsKinds'.
 *
 * @property int    $id
 * @property string $name
 */
class NormativeDocsKinds extends JsonResource
{
    /**
     * Преобразует сущность 'NormativeDocsKinds' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
