<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'FiasVersion'.
 *
 * @property int    $version
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 */
class FiasVersion extends JsonResource
{
    /**
     * Преобразует сущность 'FiasVersion' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'version' => (int) $this->version,
            'url' => (string) $this->url,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
