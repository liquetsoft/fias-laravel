<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'RoomType'.
 *
 * @property int         $rmtypeid
 * @property string      $name
 * @property string|null $shortname
 */
class RoomType extends JsonResource
{
    /**
     * Преобразует сущность 'RoomType' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'rmtypeid' => $this->rmtypeid,
            'name' => $this->name,
            'shortname' => $this->shortname,
        ];
    }
}
