<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель для тестов хранилища eloquent.
 */
class EloquentStorageTestModel extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string|null */
    protected $table = 'eloquent_storage_test_model';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var array<int, string> */
    protected $fillable = [
        'id',
        'name',
        'test_date',
    ];

    /** @var array */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'test_date' => 'datetime',
    ];
}
