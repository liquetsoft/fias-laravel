<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\NormativeDocument as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'NormativeDocument'.
 */
class NormativeDocument extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray()
    {
        $model = new stdClass;
        $model->normdocid = $this->createFakeData()->uuid;
        $model->docname = $this->createFakeData()->word;
        $model->docdate = $this->createFakeData()->dateTime();
        $model->docnum = $this->createFakeData()->word;
        $model->doctype = $this->createFakeData()->word;

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('normdocid', $array);
        $this->assertSame($model->normdocid, $array['normdocid']);
        $this->assertArrayHasKey('docname', $array);
        $this->assertSame($model->docname, $array['docname']);
        $this->assertArrayHasKey('docdate', $array);
        $this->assertSame($model->docdate->format(DateTimeInterface::ATOM), $array['docdate']);
        $this->assertArrayHasKey('docnum', $array);
        $this->assertSame($model->docnum, $array['docnum']);
        $this->assertArrayHasKey('doctype', $array);
        $this->assertSame($model->doctype, $array['doctype']);
    }
}
