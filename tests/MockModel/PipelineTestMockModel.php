<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель для тестов пайплайнов.
 */
final class PipelineTestMockModel extends Model
{
    public $timestamps = false;

    public $incrementing = false;

    protected $table = 'pipeline_test_model';

    protected $primaryKey = 'testId';

    protected $fillable = [
        'testId',
        'testName',
        'startdate',
        'uuid',
        'stringCode',
    ];

    protected $casts = [
        'testId' => 'integer',
        'testName' => 'string',
        'startdate' => 'datetime',
        'uuid' => 'string',
        'stringCode' => 'string',
    ];
}
