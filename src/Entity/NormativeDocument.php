<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по нормативному документу, являющемуся основанием присвоения адресному элементу наименования.
 *
 * @property string $normdocid
 * @property string $docname
 * @property Carbon $docdate
 * @property string $docnum
 * @property string $doctype
 */
class NormativeDocument extends Model
{
    /** @var string */
    protected $table = 'fias_laravel_normative_document';

    /** @var string[] */
    protected $fillable = [
        'normdocid',
        'docname',
        'docdate',
        'docnum',
        'doctype',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'docname' => 'string',
        'docdate' => 'datetime',
        'docnum' => 'string',
        'doctype' => 'string',
    ];

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
