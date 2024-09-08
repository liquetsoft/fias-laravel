<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\FiasVersion as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * Тест ресурса для сущности 'FiasVersion'.
 */
class FiasVersion extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new \stdClass();
        $model->version = $this->createFakeData()->numberBetween(1, 1000000);
        $model->fullurl = $this->createFakeData()->word();
        $model->deltaurl = $this->createFakeData()->word();
        $model->created_at = $this->createFakeData()->dateTime();

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('version', $array);
        $this->assertSame($model->version, $array['version']);
        $this->assertArrayHasKey('fullurl', $array);
        $this->assertSame($model->fullurl, $array['fullurl']);
        $this->assertArrayHasKey('deltaurl', $array);
        $this->assertSame($model->deltaurl, $array['deltaurl']);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertSame($model->created_at->format(\DateTimeInterface::ATOM), $array['created_at']);
    }
}
