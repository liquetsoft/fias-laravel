<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\CurrentStatus as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'CurrentStatus'.
 */
class CurrentStatus extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray()
    {
        $model = new stdClass();
        $model->curentstid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->name = $this->createFakeData()->word;

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('curentstid', $array);
        $this->assertSame($model->curentstid, $array['curentstid']);
        $this->assertArrayHasKey('name', $array);
        $this->assertSame($model->name, $array['name']);
    }
}
