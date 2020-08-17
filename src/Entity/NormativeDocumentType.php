<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Тип нормативного документа.
 *
 * @property int    $ndtypeid Идентификатор записи (ключ)
 * @property string $name     Наименование типа нормативного документа
 */
class NormativeDocumentType extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_normative_document_type';

    /** @var string */
    protected $primaryKey = 'ndtypeid';

    /** @var string[] */
    protected $fillable = [
        'ndtypeid',
        'name',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'ndtypeid' => 'integer',
        'name' => 'string',
    ];
}
