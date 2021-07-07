<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\AddressObjectType as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'AddressObjectType'.
 */
class AddressObjectType extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new stdClass();
        $model->kod_t_st = $this->createFakeData()->word();
        $model->level = $this->createFakeData()->numberBetween(1, 1000000);
        $model->socrname = $this->createFakeData()->word();
        $model->scname = $this->createFakeData()->word();

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('kod_t_st', $array);
        $this->assertSame($model->kod_t_st, $array['kod_t_st']);
        $this->assertArrayHasKey('level', $array);
        $this->assertSame($model->level, $array['level']);
        $this->assertArrayHasKey('socrname', $array);
        $this->assertSame($model->socrname, $array['socrname']);
        $this->assertArrayHasKey('scname', $array);
        $this->assertSame($model->scname, $array['scname']);
    }
}
