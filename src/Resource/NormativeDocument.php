<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'NormativeDocument'.
 */
class NormativeDocument extends JsonResource
{
    /**
     * Преобразует сущность 'NormativeDocument' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return[
            'normdocid' => $this->normdocid ?? null,
            'docname' => $this->docname ?? null,
            'docdate' => $this->docdate ?? null,
            'docnum' => $this->docnum ?? null,
            'doctype' => $this->doctype ?? null,
        ];
    }
}
