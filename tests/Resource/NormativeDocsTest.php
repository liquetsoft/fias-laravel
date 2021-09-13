<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Resource;

use DateTimeInterface;
use Illuminate\Http\Request;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Resource\NormativeDocs as Resource;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use stdClass;

/**
 * Тест ресурса для сущности 'NormativeDocs'.
 */
class NormativeDocs extends BaseCase
{
    /**
     * Проверяет, что ресурс верно преобразует сущность в массив.
     */
    public function testToArray(): void
    {
        $model = new stdClass();
        $model->id = $this->createFakeData()->numberBetween(1, 1000000);
        $model->name = $this->createFakeData()->word();
        $model->date = $this->createFakeData()->dateTime();
        $model->number = $this->createFakeData()->word();
        $model->type = $this->createFakeData()->numberBetween(1, 1000000);
        $model->kind = $this->createFakeData()->numberBetween(1, 1000000);
        $model->updatedate = $this->createFakeData()->dateTime();
        $model->orgname = $this->createFakeData()->word();
        $model->regnum = $this->createFakeData()->word();
        $model->regdate = $this->createFakeData()->dateTime();
        $model->accdate = $this->createFakeData()->dateTime();
        $model->comment = $this->createFakeData()->word();

        $resource = new Resource($model);
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $array = $resource->toArray($request);

        $this->assertArrayHasKey('id', $array);
        $this->assertSame($model->id, $array['id']);
        $this->assertArrayHasKey('name', $array);
        $this->assertSame($model->name, $array['name']);
        $this->assertArrayHasKey('date', $array);
        $this->assertSame($model->date->format(DateTimeInterface::ATOM), $array['date']);
        $this->assertArrayHasKey('number', $array);
        $this->assertSame($model->number, $array['number']);
        $this->assertArrayHasKey('type', $array);
        $this->assertSame($model->type, $array['type']);
        $this->assertArrayHasKey('kind', $array);
        $this->assertSame($model->kind, $array['kind']);
        $this->assertArrayHasKey('updatedate', $array);
        $this->assertSame($model->updatedate->format(DateTimeInterface::ATOM), $array['updatedate']);
        $this->assertArrayHasKey('orgname', $array);
        $this->assertSame($model->orgname, $array['orgname']);
        $this->assertArrayHasKey('regnum', $array);
        $this->assertSame($model->regnum, $array['regnum']);
        $this->assertArrayHasKey('regdate', $array);
        $this->assertSame($model->regdate->format(DateTimeInterface::ATOM), $array['regdate']);
        $this->assertArrayHasKey('accdate', $array);
        $this->assertSame($model->accdate->format(DateTimeInterface::ATOM), $array['accdate']);
        $this->assertArrayHasKey('comment', $array);
        $this->assertSame($model->comment, $array['comment']);
    }
}
