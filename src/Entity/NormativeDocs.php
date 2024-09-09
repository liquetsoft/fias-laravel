<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Сведения о нормативном документе, являющемся основанием присвоения адресному элементу наименования.
 *
 * @psalm-consistent-constructor
 *
 * @property int                     $id         Уникальный идентификатор документа
 * @property string                  $name       Наименование документа
 * @property \DateTimeInterface      $date       Дата документа
 * @property string                  $number     Номер документа
 * @property int                     $type       Тип документа
 * @property int                     $kind       Вид документа
 * @property \DateTimeInterface      $updatedate Дата обновления
 * @property string|null             $orgname    Наименование органа создвшего нормативный документ
 * @property string|null             $regnum     Номер государственной регистрации
 * @property \DateTimeInterface|null $regdate    Дата государственной регистрации
 * @property \DateTimeInterface|null $accdate    Дата вступления в силу нормативного документа
 * @property string|null             $comment    Комментарий
 */
class NormativeDocs extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_normative_docs';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var array<int, string> */
    protected $fillable = [
        'id',
        'name',
        'date',
        'number',
        'type',
        'kind',
        'updatedate',
        'orgname',
        'regnum',
        'regdate',
        'accdate',
        'comment',
    ];

    /** @var array */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'date' => 'datetime',
        'number' => 'string',
        'type' => 'integer',
        'kind' => 'integer',
        'updatedate' => 'datetime',
        'orgname' => 'string',
        'regnum' => 'string',
        'regdate' => 'datetime',
        'accdate' => 'datetime',
        'comment' => 'string',
    ];

    /**
     * {@inheritDoc}
     *
     * @psalm-suppress MixedMethodCall
     */
    public function getConnectionName()
    {
        $connection = $this->connection;
        if (\function_exists('app') && app()->has('config') === true) {
            /** @var string|null */
            $connection = app('config')->get('liquetsoft_fias.eloquent_connection') ?: $this->connection;
        }

        return $connection;
    }
}
