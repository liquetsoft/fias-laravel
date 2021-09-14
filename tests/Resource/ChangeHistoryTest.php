<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\ChangeHistory as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'ChangeHistory'.
 */
class ChangeHistory extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new stdClass();
        $model->changeid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->objectid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->adrobjectid = $this->createFakeData()->uuid();
        $model->opertypeid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->ndocid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->changedate = $this->createFakeData()->dateTime();

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('changeid', $array);
        $this->assertSame($model->changeid, $array['changeid']);
        $this->assertArrayHasKey('objectid', $array);
        $this->assertSame($model->objectid, $array['objectid']);
        $this->assertArrayHasKey('adrobjectid', $array);
        $this->assertSame($model->adrobjectid, $array['adrobjectid']);
        $this->assertArrayHasKey('opertypeid', $array);
        $this->assertSame($model->opertypeid, $array['opertypeid']);
        $this->assertArrayHasKey('ndocid', $array);
        $this->assertSame($model->ndocid, $array['ndocid']);
        $this->assertArrayHasKey('changedate', $array);
        $this->assertSame($model->changedate->format(DateTimeInterface::ATOM), $array['changedate']);
    }
}
