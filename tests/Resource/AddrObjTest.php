<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\AddrObj as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест ресурса для сущности 'AddrObj'.
 *
 * @internal
 */
final class AddrObjTest extends BaseCase
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
        $model->name = $this->createFakeData()->word();
        $model->typename = $this->createFakeData()->word();
        $model->level = $this->createFakeData()->word();
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
        $this->assertArrayHasKey('name', $array);
        $this->assertSame($model->name, $array['name']);
        $this->assertArrayHasKey('typename', $array);
        $this->assertSame($model->typename, $array['typename']);
        $this->assertArrayHasKey('level', $array);
        $this->assertSame($model->level, $array['level']);
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
