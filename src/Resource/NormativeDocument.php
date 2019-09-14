<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'NormativeDocument'.
 *
 * @property string $normdocid
 * @property string $docname
 * @property Carbon $docdate
 * @property string $docnum
 * @property string $doctype
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
        return [
            'normdocid' => $this->normdocid,
            'docname' => $this->docname,
            'docdate' => $this->docdate,
            'docnum' => $this->docnum,
            'doctype' => $this->doctype,
        ];
    }
}
