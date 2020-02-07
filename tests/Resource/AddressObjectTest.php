<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\AddressObject as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'AddressObject'.
 */
class AddressObject extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray()
    {
        $model = new stdClass;
        $model->aoid = $this->createFakeData()->uuid;
        $model->aoguid = $this->createFakeData()->uuid;
        $model->parentguid = $this->createFakeData()->uuid;
        $model->previd = $this->createFakeData()->uuid;
        $model->nextid = $this->createFakeData()->uuid;
        $model->code = $this->createFakeData()->word;
        $model->formalname = $this->createFakeData()->word;
        $model->offname = $this->createFakeData()->word;
        $model->shortname = $this->createFakeData()->word;
        $model->aolevel = $this->createFakeData()->numberBetween(1, 1000000);
        $model->regioncode = $this->createFakeData()->word;
        $model->areacode = $this->createFakeData()->word;
        $model->autocode = $this->createFakeData()->word;
        $model->citycode = $this->createFakeData()->word;
        $model->ctarcode = $this->createFakeData()->word;
        $model->placecode = $this->createFakeData()->word;
        $model->plancode = $this->createFakeData()->word;
        $model->streetcode = $this->createFakeData()->word;
        $model->extrcode = $this->createFakeData()->word;
        $model->sextcode = $this->createFakeData()->word;
        $model->plaincode = $this->createFakeData()->word;
        $model->currstatus = $this->createFakeData()->numberBetween(1, 1000000);
        $model->actstatus = $this->createFakeData()->numberBetween(1, 1000000);
        $model->livestatus = $this->createFakeData()->numberBetween(1, 1000000);
        $model->centstatus = $this->createFakeData()->numberBetween(1, 1000000);
        $model->operstatus = $this->createFakeData()->numberBetween(1, 1000000);
        $model->ifnsfl = $this->createFakeData()->word;
        $model->ifnsul = $this->createFakeData()->word;
        $model->terrifnsfl = $this->createFakeData()->word;
        $model->terrifnsul = $this->createFakeData()->word;
        $model->okato = $this->createFakeData()->word;
        $model->oktmo = $this->createFakeData()->word;
        $model->postalcode = $this->createFakeData()->word;
        $model->startdate = $this->createFakeData()->dateTime();
        $model->enddate = $this->createFakeData()->dateTime();
        $model->updatedate = $this->createFakeData()->dateTime();
        $model->divtype = $this->createFakeData()->numberBetween(1, 1000000);

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('aoid', $array);
        $this->assertSame($model->aoid, $array['aoid']);
        $this->assertArrayHasKey('aoguid', $array);
        $this->assertSame($model->aoguid, $array['aoguid']);
        $this->assertArrayHasKey('parentguid', $array);
        $this->assertSame($model->parentguid, $array['parentguid']);
        $this->assertArrayHasKey('previd', $array);
        $this->assertSame($model->previd, $array['previd']);
        $this->assertArrayHasKey('nextid', $array);
        $this->assertSame($model->nextid, $array['nextid']);
        $this->assertArrayHasKey('code', $array);
        $this->assertSame($model->code, $array['code']);
        $this->assertArrayHasKey('formalname', $array);
        $this->assertSame($model->formalname, $array['formalname']);
        $this->assertArrayHasKey('offname', $array);
        $this->assertSame($model->offname, $array['offname']);
        $this->assertArrayHasKey('shortname', $array);
        $this->assertSame($model->shortname, $array['shortname']);
        $this->assertArrayHasKey('aolevel', $array);
        $this->assertSame($model->aolevel, $array['aolevel']);
        $this->assertArrayHasKey('regioncode', $array);
        $this->assertSame($model->regioncode, $array['regioncode']);
        $this->assertArrayHasKey('areacode', $array);
        $this->assertSame($model->areacode, $array['areacode']);
        $this->assertArrayHasKey('autocode', $array);
        $this->assertSame($model->autocode, $array['autocode']);
        $this->assertArrayHasKey('citycode', $array);
        $this->assertSame($model->citycode, $array['citycode']);
        $this->assertArrayHasKey('ctarcode', $array);
        $this->assertSame($model->ctarcode, $array['ctarcode']);
        $this->assertArrayHasKey('placecode', $array);
        $this->assertSame($model->placecode, $array['placecode']);
        $this->assertArrayHasKey('plancode', $array);
        $this->assertSame($model->plancode, $array['plancode']);
        $this->assertArrayHasKey('streetcode', $array);
        $this->assertSame($model->streetcode, $array['streetcode']);
        $this->assertArrayHasKey('extrcode', $array);
        $this->assertSame($model->extrcode, $array['extrcode']);
        $this->assertArrayHasKey('sextcode', $array);
        $this->assertSame($model->sextcode, $array['sextcode']);
        $this->assertArrayHasKey('plaincode', $array);
        $this->assertSame($model->plaincode, $array['plaincode']);
        $this->assertArrayHasKey('currstatus', $array);
        $this->assertSame($model->currstatus, $array['currstatus']);
        $this->assertArrayHasKey('actstatus', $array);
        $this->assertSame($model->actstatus, $array['actstatus']);
        $this->assertArrayHasKey('livestatus', $array);
        $this->assertSame($model->livestatus, $array['livestatus']);
        $this->assertArrayHasKey('centstatus', $array);
        $this->assertSame($model->centstatus, $array['centstatus']);
        $this->assertArrayHasKey('operstatus', $array);
        $this->assertSame($model->operstatus, $array['operstatus']);
        $this->assertArrayHasKey('ifnsfl', $array);
        $this->assertSame($model->ifnsfl, $array['ifnsfl']);
        $this->assertArrayHasKey('ifnsul', $array);
        $this->assertSame($model->ifnsul, $array['ifnsul']);
        $this->assertArrayHasKey('terrifnsfl', $array);
        $this->assertSame($model->terrifnsfl, $array['terrifnsfl']);
        $this->assertArrayHasKey('terrifnsul', $array);
        $this->assertSame($model->terrifnsul, $array['terrifnsul']);
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
        $this->assertArrayHasKey('divtype', $array);
        $this->assertSame($model->divtype, $array['divtype']);
    }
}
