<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\ObjectLevels as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'ObjectLevels'.
 */
class ObjectLevels extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new stdClass();
        $model->level = $this->createFakeData()->numberBetween(1, 1000000);
        $model->name = $this->createFakeData()->word();
        $model->shortname = $this->createFakeData()->word();
        $model->updatedate = $this->createFakeData()->dateTime();
        $model->startdate = $this->createFakeData()->dateTime();
        $model->enddate = $this->createFakeData()->dateTime();
        $model->isactive = $this->createFakeData()->word();

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('level', $array);
        $this->assertSame($model->level, $array['level']);
        $this->assertArrayHasKey('name', $array);
        $this->assertSame($model->name, $array['name']);
        $this->assertArrayHasKey('shortname', $array);
        $this->assertSame($model->shortname, $array['shortname']);
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
