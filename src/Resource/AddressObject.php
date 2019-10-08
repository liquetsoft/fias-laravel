<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ресурс для сущности 'AddressObject'.
 *
 * @property string                   $aoid
 * @property string|null              $aoguid
 * @property string|null              $parentguid
 * @property string|null              $previd
 * @property string|null              $nextid
 * @property string|null              $code
 * @property string                   $formalname
 * @property string                   $offname
 * @property string                   $shortname
 * @property int                      $aolevel
 * @property string                   $regioncode
 * @property string                   $areacode
 * @property string                   $autocode
 * @property string                   $citycode
 * @property string                   $ctarcode
 * @property string                   $placecode
 * @property string                   $plancode
 * @property string                   $streetcode
 * @property string                   $extrcode
 * @property string                   $sextcode
 * @property string|null              $plaincode
 * @property int                      $currstatus
 * @property int                      $actstatus
 * @property int                      $livestatus
 * @property int                      $centstatus
 * @property int                      $operstatus
 * @property string|null              $ifnsfl
 * @property string|null              $ifnsul
 * @property string|null              $terrifnsfl
 * @property string|null              $terrifnsul
 * @property string|null              $okato
 * @property string|null              $oktmo
 * @property string|null              $postalcode
 * @property DateTimeInterface|string $startdate
 * @property DateTimeInterface|string $enddate
 * @property DateTimeInterface|string $updatedate
 * @property int                      $divtype
 */
class AddressObject extends JsonResource
{
    /**
     * Преобразует сущность 'AddressObject' в массив.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'aoid' => (string) $this->aoid,
            'aoguid' => (string) $this->aoguid,
            'parentguid' => (string) $this->parentguid,
            'previd' => (string) $this->previd,
            'nextid' => (string) $this->nextid,
            'code' => (string) $this->code,
            'formalname' => (string) $this->formalname,
            'offname' => (string) $this->offname,
            'shortname' => (string) $this->shortname,
            'aolevel' => (int) $this->aolevel,
            'regioncode' => (string) $this->regioncode,
            'areacode' => (string) $this->areacode,
            'autocode' => (string) $this->autocode,
            'citycode' => (string) $this->citycode,
            'ctarcode' => (string) $this->ctarcode,
            'placecode' => (string) $this->placecode,
            'plancode' => (string) $this->plancode,
            'streetcode' => (string) $this->streetcode,
            'extrcode' => (string) $this->extrcode,
            'sextcode' => (string) $this->sextcode,
            'plaincode' => (string) $this->plaincode,
            'currstatus' => (int) $this->currstatus,
            'actstatus' => (int) $this->actstatus,
            'livestatus' => (int) $this->livestatus,
            'centstatus' => (int) $this->centstatus,
            'operstatus' => (int) $this->operstatus,
            'ifnsfl' => (string) $this->ifnsfl,
            'ifnsul' => (string) $this->ifnsul,
            'terrifnsfl' => (string) $this->terrifnsfl,
            'terrifnsul' => (string) $this->terrifnsul,
            'okato' => (string) $this->okato,
            'oktmo' => (string) $this->oktmo,
            'postalcode' => (string) $this->postalcode,
            'startdate' => $this->startdate instanceof DateTimeInterface ? $this->startdate->format('Y-m-d H:i:s') : (string) $this->startdate,
            'enddate' => $this->enddate instanceof DateTimeInterface ? $this->enddate->format('Y-m-d H:i:s') : (string) $this->enddate,
            'updatedate' => $this->updatedate instanceof DateTimeInterface ? $this->updatedate->format('Y-m-d H:i:s') : (string) $this->updatedate,
            'divtype' => (int) $this->divtype,
        ];
    }
}
