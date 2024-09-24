<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'FiasVersion'.
 *
 * @property int                $version
 * @property string             $fullurl
 * @property string             $deltaurl
 * @property \DateTimeInterface $created_at
 */
final class FiasVersion extends JsonResource
{
    /**
     * Преобразует сущность 'FiasVersion' в массив.
     *
     * @param Request $request
     */
    public function toArray($request): array
    {
        return [
            'version' => $this->version,
            'fullurl' => $this->fullurl,
            'deltaurl' => $this->deltaurl,
            'created_at' => $this->created_at->format(\DateTimeInterface::ATOM),
        ];
    }
}
