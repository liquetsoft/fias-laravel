<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Типы нормативных документов.
 *
 * @property int    $ndtypeid
 * @property string $name
 */
class NormativeDocumentType extends Model
{
    /** @var string */
    protected $table = 'fias_laravel_normative_document_type';

    /** @var string[] */
    protected $fillable = [
        'ndtypeid',
        'name',
    ];

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
