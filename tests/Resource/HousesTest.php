<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\Houses as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест ресурса для сущности 'Houses'.
 *
 * @internal
 */
class HousesTest extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new \stdClass();
        $model->id = $this->createFakeData()->numberBetween(1, 1000000);
        $model->objectid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->objectguid = $this->createFakeData()->uuid();
        $model->changeid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->housenum = $this->createFakeData()->word();
        $model->addnum1 = $this->createFakeData()->word();
        $model->addnum2 = $this->createFakeData()->word();
        $model->housetype = $this->createFakeData()->numberBetween(1, 1000000);
        $model->addtype1 = $this->createFakeData()->numberBetween(1, 1000000);
        $model->addtype2 = $this->createFakeData()->numberBetween(1, 1000000);
        $model->opertypeid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->previd = $this->createFakeData()->numberBetween(1, 1000000);
        $model->nextid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->updatedate = $this->createFakeData()->dateTime();
        $model->startdate = $this->createFakeData()->dateTime();
        $model->enddate = $this->createFakeData()->dateTime();
        $model->isactual = $this->createFakeData()->numberBetween(1, 1000000);
        $model->isactive = $this->createFakeData()->numberBetween(1, 1000000);

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('id', $array);
        $this->assertSame($model->id, $array['id']);
        $this->assertArrayHasKey('objectid', $array);
        $this->assertSame($model->objectid, $array['objectid']);
        $this->assertArrayHasKey('objectguid', $array);
        $this->assertSame($model->objectguid, $array['objectguid']);
        $this->assertArrayHasKey('changeid', $array);
        $this->assertSame($model->changeid, $array['changeid']);
        $this->assertArrayHasKey('housenum', $array);
        $this->assertSame($model->housenum, $array['housenum']);
        $this->assertArrayHasKey('addnum1', $array);
        $this->assertSame($model->addnum1, $array['addnum1']);
        $this->assertArrayHasKey('addnum2', $array);
        $this->assertSame($model->addnum2, $array['addnum2']);
        $this->assertArrayHasKey('housetype', $array);
        $this->assertSame($model->housetype, $array['housetype']);
        $this->assertArrayHasKey('addtype1', $array);
        $this->assertSame($model->addtype1, $array['addtype1']);
        $this->assertArrayHasKey('addtype2', $array);
        $this->assertSame($model->addtype2, $array['addtype2']);
        $this->assertArrayHasKey('opertypeid', $array);
        $this->assertSame($model->opertypeid, $array['opertypeid']);
        $this->assertArrayHasKey('previd', $array);
        $this->assertSame($model->previd, $array['previd']);
        $this->assertArrayHasKey('nextid', $array);
        $this->assertSame($model->nextid, $array['nextid']);
        $this->assertArrayHasKey('updatedate', $array);
        $this->assertSame($model->updatedate->format(\DateTimeInterface::ATOM), $array['updatedate']);
        $this->assertArrayHasKey('startdate', $array);
        $this->assertSame($model->startdate->format(\DateTimeInterface::ATOM), $array['startdate']);
        $this->assertArrayHasKey('enddate', $array);
        $this->assertSame($model->enddate->format(\DateTimeInterface::ATOM), $array['enddate']);
        $this->assertArrayHasKey('isactual', $array);
        $this->assertSame($model->isactual, $array['isactual']);
        $this->assertArrayHasKey('isactive', $array);
        $this->assertSame($model->isactive, $array['isactive']);
    }
}
