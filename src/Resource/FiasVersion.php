<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'FiasVersion'.
 *
 * @property int               $version
 * @property string            $url
 * @property DateTimeInterface $created_at
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
            'version' => $this->version,
            'url' => $this->url,
            'created_at' => $this->created_at->format(DateTimeInterface::ATOM),
        ];
    }
}
