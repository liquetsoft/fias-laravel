<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\Param as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест ресурса для сущности 'Param'.
 *
 * @internal
 */
class ParamTest extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new \stdClass();
        $model->id = $this->createFakeData()->numberBetween(1, 1000000);
        $model->objectid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->changeid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->changeidend = $this->createFakeData()->numberBetween(1, 1000000);
        $model->typeid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->value = $this->createFakeData()->word();
        $model->updatedate = $this->createFakeData()->dateTime();
        $model->startdate = $this->createFakeData()->dateTime();
        $model->enddate = $this->createFakeData()->dateTime();

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('id', $array);
        $this->assertSame($model->id, $array['id']);
        $this->assertArrayHasKey('objectid', $array);
        $this->assertSame($model->objectid, $array['objectid']);
        $this->assertArrayHasKey('changeid', $array);
        $this->assertSame($model->changeid, $array['changeid']);
        $this->assertArrayHasKey('changeidend', $array);
        $this->assertSame($model->changeidend, $array['changeidend']);
        $this->assertArrayHasKey('typeid', $array);
        $this->assertSame($model->typeid, $array['typeid']);
        $this->assertArrayHasKey('value', $array);
        $this->assertSame($model->value, $array['value']);
        $this->assertArrayHasKey('updatedate', $array);
        $this->assertSame($model->updatedate->format(\DateTimeInterface::ATOM), $array['updatedate']);
        $this->assertArrayHasKey('startdate', $array);
        $this->assertSame($model->startdate->format(\DateTimeInterface::ATOM), $array['startdate']);
        $this->assertArrayHasKey('enddate', $array);
        $this->assertSame($model->enddate->format(\DateTimeInterface::ATOM), $array['enddate']);
    }
}
