<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\AdmHierarchy as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест ресурса для сущности 'AdmHierarchy'.
 *
 * @internal
 */
final class AdmHierarchyTest extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new \stdClass();
        $model->id = $this->createFakeData()->numberBetween(1, 1000000);
        $model->objectid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->parentobjid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->changeid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->regioncode = $this->createFakeData()->word();
        $model->areacode = $this->createFakeData()->word();
        $model->citycode = $this->createFakeData()->word();
        $model->placecode = $this->createFakeData()->word();
        $model->plancode = $this->createFakeData()->word();
        $model->streetcode = $this->createFakeData()->word();
        $model->previd = $this->createFakeData()->numberBetween(1, 1000000);
        $model->nextid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->updatedate = $this->createFakeData()->dateTime();
        $model->startdate = $this->createFakeData()->dateTime();
        $model->enddate = $this->createFakeData()->dateTime();
        $model->isactive = $this->createFakeData()->numberBetween(1, 1000000);
        $model->path = $this->createFakeData()->word();

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('id', $array);
        $this->assertSame($model->id, $array['id']);
        $this->assertArrayHasKey('objectid', $array);
        $this->assertSame($model->objectid, $array['objectid']);
        $this->assertArrayHasKey('parentobjid', $array);
        $this->assertSame($model->parentobjid, $array['parentobjid']);
        $this->assertArrayHasKey('changeid', $array);
        $this->assertSame($model->changeid, $array['changeid']);
        $this->assertArrayHasKey('regioncode', $array);
        $this->assertSame($model->regioncode, $array['regioncode']);
        $this->assertArrayHasKey('areacode', $array);
        $this->assertSame($model->areacode, $array['areacode']);
        $this->assertArrayHasKey('citycode', $array);
        $this->assertSame($model->citycode, $array['citycode']);
        $this->assertArrayHasKey('placecode', $array);
        $this->assertSame($model->placecode, $array['placecode']);
        $this->assertArrayHasKey('plancode', $array);
        $this->assertSame($model->plancode, $array['plancode']);
        $this->assertArrayHasKey('streetcode', $array);
        $this->assertSame($model->streetcode, $array['streetcode']);
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
        $this->assertArrayHasKey('isactive', $array);
        $this->assertSame($model->isactive, $array['isactive']);
        $this->assertArrayHasKey('path', $array);
        $this->assertSame($model->path, $array['path']);
    }
}
