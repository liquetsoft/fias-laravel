<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Статус действия.
 *
 * @property int    $operstatid Идентификатор статуса (ключ)
 * @property string $name       Наименование
 *                              01 – Инициация;
 *                              10 – Добавление;
 *                              20 – Изменение;
 *                              21 – Групповое изменение;
 *                              30 – Удаление;
 *                              31 - Удаление вследствие удаления вышестоящего объекта;
 *                              40 – Присоединение адресного объекта (слияние);
 *                              41 – Переподчинение вследствие слияния вышестоящего объекта;
 *                              42 - Прекращение существования вследствие присоединения к другому адресному объекту;
 *                              43 - Создание нового адресного объекта в результате слияния адресных объектов;
 *                              50 – Переподчинение;
 *                              51 – Переподчинение вследствие переподчинения вышестоящего объекта;
 *                              60 – Прекращение существования вследствие дробления;
 *                              61 – Создание нового адресного объекта в результате дробления;
 *                              70 – Восстановление объекта прекратившего существование
 */
class OperationStatus extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'fias_laravel_operation_status';

    /** @var string */
    protected $primaryKey = 'operstatid';

    /** @var string[] */
    protected $fillable = [
        'operstatid',
        'name',
    ];

    /** @var array */
    protected $casts = [
        'operstatid' => 'integer',
        'name' => 'string',
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
