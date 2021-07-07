<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\EstateStatus as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'EstateStatus'.
 */
class EstateStatus extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new stdClass();
        $model->eststatid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->name = $this->createFakeData()->word();
        $model->shortname = $this->createFakeData()->word();

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('eststatid', $array);
        $this->assertSame($model->eststatid, $array['eststatid']);
        $this->assertArrayHasKey('name', $array);
        $this->assertSame($model->name, $array['name']);
        $this->assertArrayHasKey('shortname', $array);
        $this->assertSame($model->shortname, $array['shortname']);
    }
}
