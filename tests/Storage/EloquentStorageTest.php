<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Storage;

use Illuminate\Database\Eloquent\Model;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Storage\EloquentStorage;

/**
 * Тест для проверки хранилища данных eloquent.
 */
class EloquentStorageTest extends BaseCase
{
    /**
     * Проверяет, что хранилище может обновить состояние объекта или создать новый.
     */
    public function testUpsert()
    {
        $model = $this->getMockBuilder(Model::class)->disableOriginalConstructor()->getMock();
        $model->expects($this->once())->method('refresh')->will($this->returnValue($model));
        $model->expects($this->once())->method('save');

        $storage = new EloquentStorage();
        $storage->upsert($model);
    }
}