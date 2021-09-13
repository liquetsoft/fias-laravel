<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\ParamTypes as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'ParamTypes'.
 */
class ParamTypes extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new stdClass();
        $model->id = $this->createFakeData()->numberBetween(1, 1000000);
        $model->name = $this->createFakeData()->word();
        $model->code = $this->createFakeData()->word();
        $model->desc = $this->createFakeData()->word();
        $model->updatedate = $this->createFakeData()->dateTime();
        $model->startdate = $this->createFakeData()->dateTime();
        $model->enddate = $this->createFakeData()->dateTime();
        $model->isactive = $this->createFakeData()->word();

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('id', $array);
        $this->assertSame($model->id, $array['id']);
        $this->assertArrayHasKey('name', $array);
        $this->assertSame($model->name, $array['name']);
        $this->assertArrayHasKey('code', $array);
        $this->assertSame($model->code, $array['code']);
        $this->assertArrayHasKey('desc', $array);
        $this->assertSame($model->desc, $array['desc']);
        $this->assertArrayHasKey('updatedate', $array);
        $this->assertSame($model->updatedate->format(DateTimeInterface::ATOM), $array['updatedate']);
        $this->assertArrayHasKey('startdate', $array);
        $this->assertSame($model->startdate->format(DateTimeInterface::ATOM), $array['startdate']);
        $this->assertArrayHasKey('enddate', $array);
        $this->assertSame($model->enddate->format(DateTimeInterface::ATOM), $array['enddate']);
        $this->assertArrayHasKey('isactive', $array);
        $this->assertSame($model->isactive, $array['isactive']);
    }
}
