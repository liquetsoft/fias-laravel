<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel;

use Illuminate\Database\Eloquent\Model;

/**
 * Мок для проверки десериализации.
 *
 * @property int                $ACTSTATID
 * @property string             $name
 * @property float              $floatNum
 * @property bool               $boolVal
 * @property \DateTimeInterface $test_date_val
 * @property int                $timestamp
 * @property string|null        $nullableCast
 * @property string|null        $defaultItem
 */
final class FiasSerializerMock extends Model
{
    protected $dateFormat = 'Y-m-d H:i';

    protected $fillable = [
        'ACTSTATID',
        'name',
        'floatNum',
        'boolVal',
        'test_date_val',
        'timestamp',
        'defaultItem',
        'nullableCast',
    ];

    protected $casts = [
        'ACTSTATID' => 'integer',
        'name' => 'string',
        'floatNum' => 'double',
        'boolVal' => 'boolean',
        'test_date_val' => 'datetime',
        'timestamp' => 'timestamp',
        'nullableCast' => 'string',
    ];
}
