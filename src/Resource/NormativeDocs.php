<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'NormativeDocs'.
 *
 * @property int                    $id
 * @property string                 $name
 * @property DateTimeInterface      $date
 * @property string                 $number
 * @property int                    $type
 * @property int                    $kind
 * @property DateTimeInterface      $updatedate
 * @property string|null            $orgname
 * @property string|null            $regnum
 * @property DateTimeInterface|null $regdate
 * @property DateTimeInterface|null $accdate
 * @property string|null            $comment
 */
class NormativeDocs extends JsonResource
{
    /**
     * Преобразует сущность 'NormativeDocs' в массив.
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
            'date' => $this->date->format(DateTimeInterface::ATOM),
            'number' => $this->number,
            'type' => $this->type,
            'kind' => $this->kind,
            'updatedate' => $this->updatedate->format(DateTimeInterface::ATOM),
            'orgname' => $this->orgname,
            'regnum' => $this->regnum,
            'regdate' => $this->regdate ? $this->regdate->format(DateTimeInterface::ATOM) : null,
            'accdate' => $this->accdate ? $this->accdate->format(DateTimeInterface::ATOM) : null,
            'comment' => $this->comment,
        ];
    }
}
