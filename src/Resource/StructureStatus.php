<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'StructureStatus'.
 *
 * @property int         $strstatid
 * @property string      $name
 * @property string|null $shortname
 */
class StructureStatus extends JsonResource
{
    /**
     * Преобразует сущность 'StructureStatus' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'strstatid' => (int) $this->strstatid,
            'name' => (string) $this->name,
            'shortname' => (string) $this->shortname,
        ];
    }
}
