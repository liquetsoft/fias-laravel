<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\Stead as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'Stead'.
 */
class Stead extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray()
    {
        $model = new stdClass;
        $model->steadguid = $this->createFakeData()->uuid;
        $model->number = $this->createFakeData()->word;
        $model->regioncode = $this->createFakeData()->word;
        $model->postalcode = $this->createFakeData()->word;
        $model->ifnsfl = $this->createFakeData()->word;
        $model->ifnsul = $this->createFakeData()->word;
        $model->okato = $this->createFakeData()->word;
        $model->oktmo = $this->createFakeData()->word;
        $model->parentguid = $this->createFakeData()->uuid;
        $model->steadid = $this->createFakeData()->uuid;
        $model->operstatus = $this->createFakeData()->word;
        $model->startdate = $this->createFakeData()->dateTime();
        $model->enddate = $this->createFakeData()->dateTime();
        $model->updatedate = $this->createFakeData()->dateTime();
        $model->livestatus = $this->createFakeData()->word;
        $model->divtype = $this->createFakeData()->word;
        $model->normdoc = $this->createFakeData()->uuid;

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('steadguid', $array);
        $this->assertSame($model->steadguid, $array['steadguid']);
        $this->assertArrayHasKey('number', $array);
        $this->assertSame($model->number, $array['number']);
        $this->assertArrayHasKey('regioncode', $array);
        $this->assertSame($model->regioncode, $array['regioncode']);
        $this->assertArrayHasKey('postalcode', $array);
        $this->assertSame($model->postalcode, $array['postalcode']);
        $this->assertArrayHasKey('ifnsfl', $array);
        $this->assertSame($model->ifnsfl, $array['ifnsfl']);
        $this->assertArrayHasKey('ifnsul', $array);
        $this->assertSame($model->ifnsul, $array['ifnsul']);
        $this->assertArrayHasKey('okato', $array);
        $this->assertSame($model->okato, $array['okato']);
        $this->assertArrayHasKey('oktmo', $array);
        $this->assertSame($model->oktmo, $array['oktmo']);
        $this->assertArrayHasKey('parentguid', $array);
        $this->assertSame($model->parentguid, $array['parentguid']);
        $this->assertArrayHasKey('steadid', $array);
        $this->assertSame($model->steadid, $array['steadid']);
        $this->assertArrayHasKey('operstatus', $array);
        $this->assertSame($model->operstatus, $array['operstatus']);
        $this->assertArrayHasKey('startdate', $array);
        $this->assertSame($model->startdate->format(DateTimeInterface::ATOM), $array['startdate']);
        $this->assertArrayHasKey('enddate', $array);
        $this->assertSame($model->enddate->format(DateTimeInterface::ATOM), $array['enddate']);
        $this->assertArrayHasKey('updatedate', $array);
        $this->assertSame($model->updatedate->format(DateTimeInterface::ATOM), $array['updatedate']);
        $this->assertArrayHasKey('livestatus', $array);
        $this->assertSame($model->livestatus, $array['livestatus']);
        $this->assertArrayHasKey('divtype', $array);
        $this->assertSame($model->divtype, $array['divtype']);
        $this->assertArrayHasKey('normdoc', $array);
        $this->assertSame($model->normdoc, $array['normdoc']);
    }
}
