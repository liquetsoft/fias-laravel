<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\AddrObjDivision as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест ресурса для сущности 'AddrObjDivision'.
 *
 * @internal
 */
class AddrObjDivisionTest extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new \stdClass();
        $model->id = $this->createFakeData()->numberBetween(1, 1000000);
        $model->parentid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->childid = $this->createFakeData()->numberBetween(1, 1000000);
        $model->changeid = $this->createFakeData()->numberBetween(1, 1000000);

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('id', $array);
        $this->assertSame($model->id, $array['id']);
        $this->assertArrayHasKey('parentid', $array);
        $this->assertSame($model->parentid, $array['parentid']);
        $this->assertArrayHasKey('childid', $array);
        $this->assertSame($model->childid, $array['childid']);
        $this->assertArrayHasKey('changeid', $array);
        $this->assertSame($model->changeid, $array['changeid']);
    }
}
