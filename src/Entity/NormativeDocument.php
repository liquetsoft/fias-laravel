<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Сведения по нормативному документу, являющемуся основанием присвоения адресному элементу наименования.
 *
 * @property string                 $normdocid Идентификатор нормативного документа
 * @property string|null            $docname   Наименование документа
 * @property DateTimeInterface|null $docdate   Дата документа
 * @property string|null            $docnum    Номер документа
 * @property int                    $doctype   Тип документа
 * @property string|null            $docimgid  Идентификатор образа (внешний ключ)
 */
class NormativeDocument extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_normative_document';

    /** @var string */
    protected $primaryKey = 'normdocid';

    /** @var string */
    protected $keyType = 'string';

    /** @var string[] */
    protected $fillable = [
        'normdocid',
        'docname',
        'docdate',
        'docnum',
        'doctype',
        'docimgid',
    ];

    /** @var array */
    protected $casts = [
        'normdocid' => 'string',
        'docname' => 'string',
        'docdate' => 'datetime',
        'docnum' => 'string',
        'doctype' => 'integer',
        'docimgid' => 'string',
    ];

    /**
     * {@inheritDoc}
     */
    public function getConnectionName()
    {
        $connection = $this->connection;
        if (\function_exists('app') && app()->has('config')) {
            $connection = app('config')->get('liquetsoft_fias.eloquent_connection') ?: $this->connection;
        }

        return $connection;
    }
}
