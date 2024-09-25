<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель для тестов хранилища eloquent.
 */
class EloquentStorageTestModel extends Model
{
    public $timestamps = false;

    public $incrementing = false;

    protected $table = 'eloquent_storage_test_model';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'test_date',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'test_date' => 'datetime',
    ];
}
