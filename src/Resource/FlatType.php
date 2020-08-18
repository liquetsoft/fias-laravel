<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'FlatType'.
 *
 * @property int         $fltypeid
 * @property string      $name
 * @property string|null $shortname
 */
class FlatType extends JsonResource
{
    /**
     * Преобразует сущность 'FlatType' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'fltypeid' => $this->fltypeid,
            'name' => $this->name,
            'shortname' => $this->shortname,
        ];
    }
}
