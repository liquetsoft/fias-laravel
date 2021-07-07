<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\House as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'House'.
 */
class House extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new stdClass();
        $model->houseid = $this->createFakeData()->uuid();
        $model->houseguid = $this->createFakeData()->uuid();
        $model->aoguid = $this->createFakeData()->uuid();
        $model->housenum = $this->createFakeData()->word();
        $model->strstatus = $this->createFakeData()->numberBetween(1, 1000000);
        $model->eststatus = $this->createFakeData()->numberBetween(1, 1000000);
        $model->statstatus = $this->createFakeData()->numberBetween(1, 1000000);
        $model->ifnsfl = $this->createFakeData()->word();
        $model->ifnsul = $this->createFakeData()->word();
        $model->okato = $this->createFakeData()->word();
        $model->oktmo = $this->createFakeData()->word();
        $model->postalcode = $this->createFakeData()->word();
        $model->startdate = $this->createFakeData()->dateTime();
        $model->enddate = $this->createFakeData()->dateTime();
        $model->updatedate = $this->createFakeData()->dateTime();
        $model->counter = $this->createFakeData()->numberBetween(1, 1000000);
        $model->divtype = $this->createFakeData()->numberBetween(1, 1000000);
        $model->regioncode = $this->createFakeData()->word();
        $model->terrifnsfl = $this->createFakeData()->word();
        $model->terrifnsul = $this->createFakeData()->word();
        $model->buildnum = $this->createFakeData()->word();
        $model->strucnum = $this->createFakeData()->word();
        $model->normdoc = $this->createFakeData()->uuid();
        $model->cadnum = $this->createFakeData()->word();

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('houseid', $array);
        $this->assertSame($model->houseid, $array['houseid']);
        $this->assertArrayHasKey('houseguid', $array);
        $this->assertSame($model->houseguid, $array['houseguid']);
        $this->assertArrayHasKey('aoguid', $array);
        $this->assertSame($model->aoguid, $array['aoguid']);
        $this->assertArrayHasKey('housenum', $array);
        $this->assertSame($model->housenum, $array['housenum']);
        $this->assertArrayHasKey('strstatus', $array);
        $this->assertSame($model->strstatus, $array['strstatus']);
        $this->assertArrayHasKey('eststatus', $array);
        $this->assertSame($model->eststatus, $array['eststatus']);
        $this->assertArrayHasKey('statstatus', $array);
        $this->assertSame($model->statstatus, $array['statstatus']);
        $this->assertArrayHasKey('ifnsfl', $array);
        $this->assertSame($model->ifnsfl, $array['ifnsfl']);
        $this->assertArrayHasKey('ifnsul', $array);
        $this->assertSame($model->ifnsul, $array['ifnsul']);
        $this->assertArrayHasKey('okato', $array);
        $this->assertSame($model->okato, $array['okato']);
        $this->assertArrayHasKey('oktmo', $array);
        $this->assertSame($model->oktmo, $array['oktmo']);
        $this->assertArrayHasKey('postalcode', $array);
        $this->assertSame($model->postalcode, $array['postalcode']);
        $this->assertArrayHasKey('startdate', $array);
        $this->assertSame($model->startdate->format(DateTimeInterface::ATOM), $array['startdate']);
        $this->assertArrayHasKey('enddate', $array);
        $this->assertSame($model->enddate->format(DateTimeInterface::ATOM), $array['enddate']);
        $this->assertArrayHasKey('updatedate', $array);
        $this->assertSame($model->updatedate->format(DateTimeInterface::ATOM), $array['updatedate']);
        $this->assertArrayHasKey('counter', $array);
        $this->assertSame($model->counter, $array['counter']);
        $this->assertArrayHasKey('divtype', $array);
        $this->assertSame($model->divtype, $array['divtype']);
        $this->assertArrayHasKey('regioncode', $array);
        $this->assertSame($model->regioncode, $array['regioncode']);
        $this->assertArrayHasKey('terrifnsfl', $array);
        $this->assertSame($model->terrifnsfl, $array['terrifnsfl']);
        $this->assertArrayHasKey('terrifnsul', $array);
        $this->assertSame($model->terrifnsul, $array['terrifnsul']);
        $this->assertArrayHasKey('buildnum', $array);
        $this->assertSame($model->buildnum, $array['buildnum']);
        $this->assertArrayHasKey('strucnum', $array);
        $this->assertSame($model->strucnum, $array['strucnum']);
        $this->assertArrayHasKey('normdoc', $array);
        $this->assertSame($model->normdoc, $array['normdoc']);
        $this->assertArrayHasKey('cadnum', $array);
        $this->assertSame($model->cadnum, $array['cadnum']);
    }
}
