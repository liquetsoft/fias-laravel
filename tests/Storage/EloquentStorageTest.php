<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Storage;

use Illuminate\Database\Eloquent\Model;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Storage\EloquentStorage;
use Liquetsoft\Fias\Component\Exception\StorageException;
use Illuminate\Database\Eloquent\Builder;
use RuntimeException;
use stdClass;

/**
 * Тест для проверки хранилища данных eloquent.
 */
class EloquentStorageTest extends BaseCase
{
    /**
     * Проверяет, что хранилище может удалить указанный объект.
     */
    public function testDelete()
    {
        $model = $this->getMockBuilder(Model::class)->disableOriginalConstructor()->getMock();
        $model->expects($this->once())->method('refresh')->will($this->returnValue($model));
        $model->expects($this->once())->method('delete');

        $storage = new EloquentStorage();
        $storage->start();
        $storage->delete($model);
        $storage->stop();
    }

    /**
     * Проверяет, что хранилище перехватит ошибку удаления модели.
     */
    public function testDeleteException()
    {
        $model = $this->getMockBuilder(Model::class)->disableOriginalConstructor()->getMock();
        $model->method('refresh')->will($this->returnValue($model));
        $model->method('delete')->will($this->throwException(new RuntimeException()));

        $storage = new EloquentStorage();
        $storage->start();

        $this->expectException(StorageException::class);
        $storage->delete($model);
    }

    /**
     * Проверяет, что хранилище выбросит исключение при попытке удалить не
     * eloquent модель.
     */
    public function testDeleteWrongObjectException()
    {
        $model = new stdClass;

        $storage = new EloquentStorage();
        $storage->start();

        $this->expectException(StorageException::class);
        $storage->delete($model);
    }

    /**
     * Проверяет, что хранилище может обновить состояние объекта или создать новый.
     */
    public function testUpsert()
    {
        $model = $this->getMockBuilder(Model::class)->disableOriginalConstructor()->getMock();
        $model->expects($this->once())->method('refresh')->will($this->returnValue($model));
        $model->expects($this->once())->method('save');

        $storage = new EloquentStorage();
        $storage->start();
        $storage->upsert($model);
        $storage->stop();
    }

    /**
     * Проверяет, что хранилище перехватит ошибку сохранения модели.
     */
    public function testUpsertException()
    {
        $model = $this->getMockBuilder(Model::class)->disableOriginalConstructor()->getMock();
        $model->method('refresh')->will($this->returnValue($model));
        $model->method('save')->will($this->throwException(new RuntimeException()));

        $storage = new EloquentStorage();
        $storage->start();

        $this->expectException(StorageException::class);
        $storage->upsert($model);
    }

    /**
     * Проверяет, что хранилище выбросит исключение при попытке обновить не
     * eloquent модель.
     */
    public function testUpsertWrongObjectException()
    {
        $model = new stdClass;

        $storage = new EloquentStorage();
        $storage->start();

        $this->expectException(StorageException::class);
        $storage->upsert($model);
    }

    /**
     * Проверяет, что хранилище может удалить все свои данные.
     */
    public function testTruncate()
    {
        $query = $this->getMockBuilder(Builder::class)->disableOriginalConstructor()->getMock();
        $query->expects($this->once())->method('delete');

        EloquentStorageTestMock::$query = $query;

        $storage = new EloquentStorage();
        $storage->start();
        $storage->truncate(EloquentStorageTestMock::class);
        $storage->stop();
    }

    /**
     * Проверяет, что хранилище перехватит ошибку при очистке.
     */
    public function testTruncatetException()
    {
        $query = $this->getMockBuilder(Builder::class)->disableOriginalConstructor()->getMock();
        $query->method('delete')->will($this->throwException(new RuntimeException()));

        EloquentStorageTestMock::$query = $query;

        $storage = new EloquentStorage();
        $storage->start();

        $this->expectException(StorageException::class);
        $storage->truncate(EloquentStorageTestMock::class);
    }

    /**
     * Проверяет, что хранилище выбросит исключение при попытке обновить не
     * eloquent модель.
     */
    public function testTruncateWrongClassException()
    {
        $model = new stdClass;

        $storage = new EloquentStorage();
        $storage->start();

        $this->expectException(StorageException::class);
        $storage->truncate('test');
    }
}

/**
 * Мок для проверки truncate и других статичных методов.
 */
class EloquentStorageTestMock extends Model
{
    /**
     * @var Builder|null
     */
    public static $query;

    /**
     * @return Builder|null
     */
    public static function query(): ?Builder
    {
        return self::$query;
    }
}
