<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use DateTimeInterface;
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
    public function testToArray(): void
    {
        $model = new stdClass();
        $model->version = $this->createFakeData()->numberBetween(1, 1000000);
        $model->url = $this->createFakeData()->word();
        $model->created_at = $this->createFakeData()->dateTime();

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('version', $array);
        $this->assertSame($model->version, $array['version']);
        $this->assertArrayHasKey('url', $array);
        $this->assertSame($model->url, $array['url']);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertSame($model->created_at->format(DateTimeInterface::ATOM), $array['created_at']);
    }
}
