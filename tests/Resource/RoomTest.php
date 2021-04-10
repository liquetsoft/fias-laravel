<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\Room as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'Room'.
 */
class Room extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new stdClass();
        $model->roomid = $this->createFakeData()->uuid;
        $model->roomguid = $this->createFakeData()->uuid;
        $model->houseguid = $this->createFakeData()->uuid;
        $model->regioncode = $this->createFakeData()->word;
        $model->flatnumber = $this->createFakeData()->word;
        $model->flattype = $this->createFakeData()->numberBetween(1, 1000000);
        $model->postalcode = $this->createFakeData()->word;
        $model->startdate = $this->createFakeData()->dateTime();
        $model->enddate = $this->createFakeData()->dateTime();
        $model->updatedate = $this->createFakeData()->dateTime();
        $model->operstatus = $this->createFakeData()->numberBetween(1, 1000000);
        $model->livestatus = $this->createFakeData()->numberBetween(1, 1000000);
        $model->normdoc = $this->createFakeData()->uuid;
        $model->roomnumber = $this->createFakeData()->word;
        $model->roomtype = $this->createFakeData()->numberBetween(1, 1000000);
        $model->previd = $this->createFakeData()->uuid;
        $model->nextid = $this->createFakeData()->uuid;
        $model->cadnum = $this->createFakeData()->word;
        $model->roomcadnum = $this->createFakeData()->word;

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('roomid', $array);
        $this->assertSame($model->roomid, $array['roomid']);
        $this->assertArrayHasKey('roomguid', $array);
        $this->assertSame($model->roomguid, $array['roomguid']);
        $this->assertArrayHasKey('houseguid', $array);
        $this->assertSame($model->houseguid, $array['houseguid']);
        $this->assertArrayHasKey('regioncode', $array);
        $this->assertSame($model->regioncode, $array['regioncode']);
        $this->assertArrayHasKey('flatnumber', $array);
        $this->assertSame($model->flatnumber, $array['flatnumber']);
        $this->assertArrayHasKey('flattype', $array);
        $this->assertSame($model->flattype, $array['flattype']);
        $this->assertArrayHasKey('postalcode', $array);
        $this->assertSame($model->postalcode, $array['postalcode']);
        $this->assertArrayHasKey('startdate', $array);
        $this->assertSame($model->startdate->format(DateTimeInterface::ATOM), $array['startdate']);
        $this->assertArrayHasKey('enddate', $array);
        $this->assertSame($model->enddate->format(DateTimeInterface::ATOM), $array['enddate']);
        $this->assertArrayHasKey('updatedate', $array);
        $this->assertSame($model->updatedate->format(DateTimeInterface::ATOM), $array['updatedate']);
        $this->assertArrayHasKey('operstatus', $array);
        $this->assertSame($model->operstatus, $array['operstatus']);
        $this->assertArrayHasKey('livestatus', $array);
        $this->assertSame($model->livestatus, $array['livestatus']);
        $this->assertArrayHasKey('normdoc', $array);
        $this->assertSame($model->normdoc, $array['normdoc']);
        $this->assertArrayHasKey('roomnumber', $array);
        $this->assertSame($model->roomnumber, $array['roomnumber']);
        $this->assertArrayHasKey('roomtype', $array);
        $this->assertSame($model->roomtype, $array['roomtype']);
        $this->assertArrayHasKey('previd', $array);
        $this->assertSame($model->previd, $array['previd']);
        $this->assertArrayHasKey('nextid', $array);
        $this->assertSame($model->nextid, $array['nextid']);
        $this->assertArrayHasKey('cadnum', $array);
        $this->assertSame($model->cadnum, $array['cadnum']);
        $this->assertArrayHasKey('roomcadnum', $array);
        $this->assertSame($model->roomcadnum, $array['roomcadnum']);
    }
}
