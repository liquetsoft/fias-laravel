<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'NormativeDocument'.
 *
 * @property string                 $normdocid
 * @property string|null            $docname
 * @property DateTimeInterface|null $docdate
 * @property string|null            $docnum
 * @property int                    $doctype
 * @property string|null            $docimgid
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
            'docdate' => $this->docdate ? $this->docdate->format(DateTimeInterface::ATOM) : null,
            'docnum' => $this->docnum,
            'doctype' => $this->doctype,
            'docimgid' => $this->docimgid,
        ];
    }
}
