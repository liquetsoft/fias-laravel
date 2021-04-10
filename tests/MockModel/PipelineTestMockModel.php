<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель для тестов пайплайнов.
 */
class PipelineTestMockModel extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'pipeline_test_model';

    /** @var string */
    protected $primaryKey = 'testId';

    /** @var string[] */
    protected $fillable = [
        'testId',
        'testName',
        'startdate',
        'uuid',
    ];

    /** @var array */
    protected $casts = [
        'testId' => 'integer',
        'testName' => 'string',
        'startdate' => 'datetime',
        'uuid' => 'string',
    ];
}
