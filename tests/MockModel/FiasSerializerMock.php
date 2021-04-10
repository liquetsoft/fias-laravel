<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel;

use Illuminate\Database\Eloquent\Model;

/**
 * Мок для проверки десериалищации.
 */
class FiasSerializerMock extends Model
{
    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i';

    /**
     * @var array<array-key, string>
     */
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

    /**
     * @var array
     */
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
