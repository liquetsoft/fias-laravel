<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\NormativeDocumentType as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'NormativeDocumentType'.
 */
class NormativeDocumentType extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new stdClass();
        $model->ndtypeid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->name = $this->createFakeData()->word();

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('ndtypeid', $array);
        $this->assertSame($model->ndtypeid, $array['ndtypeid']);
        $this->assertArrayHasKey('name', $array);
        $this->assertSame($model->name, $array['name']);
    }
}
