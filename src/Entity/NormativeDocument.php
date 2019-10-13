<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по нормативному документу, являющемуся основанием присвоения адресному элементу наименования.
 *
 * @property string      $normdocid
 * @property string|null $docname
 * @property Carbon|null $docdate
 * @property string|null $docnum
 * @property string      $doctype
 */
class NormativeDocument extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'fias_laravel_normative_document';

    /** @var string */
    protected $primaryKey = 'normdocid';

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
        'doctype' => 'string',
    ];

    /**
     * @inheritDoc
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}
