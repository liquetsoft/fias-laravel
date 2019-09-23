<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'NormativeDocument'.
 *
 * @property string                   $normdocid
 * @property string                   $docname
 * @property DateTimeInterface|string $docdate
 * @property string                   $docnum
 * @property string                   $doctype
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
            'normdocid' => (string) $this->normdocid,
            'docname' => (string) $this->docname,
            'docdate' => $this->docdate instanceof DateTimeInterface ? $this->docdate->format('Y-m-d H:i:s') : (string) $this->docdate,
            'docnum' => (string) $this->docnum,
            'doctype' => (string) $this->doctype,
        ];
    }
}
