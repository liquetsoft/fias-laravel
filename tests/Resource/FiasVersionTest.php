<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\FiasVersion as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'FiasVersion'.
 */
class FiasVersion extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray()
    {
        $model = new stdClass;
        $model->version = $this->createFakeData()->numberBetween(1, 1000000);
        $model->url = $this->createFakeData()->word;
        $model->created_at = $this->createFakeData()->word;
        $model->updated_at = $this->createFakeData()->word;

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('version', $array);
        $this->assertSame($model->version, $array['version']);
        $this->assertArrayHasKey('url', $array);
        $this->assertSame($model->url, $array['url']);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertSame($model->created_at, $array['created_at']);
        $this->assertArrayHasKey('updated_at', $array);
        $this->assertSame($model->updated_at, $array['updated_at']);
    }
}
