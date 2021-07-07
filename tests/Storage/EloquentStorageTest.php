<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Storage;

use DateTimeImmutable;
use Liquetsoft\Fias\Component\Exception\StorageException;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Storage\EloquentStorage;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\EloquentTestCase;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel\EloquentStorageTestModel;

/**
 * Класс для проверки хранилища, которое использует eloquent.
 *
 * @internal
 */
class EloquentStorageTest extends EloquentTestCase
{
    /**
     * Создает таблицу в бд перед тестами.
     */
    protected function setUp(): void
    {
        $this->prepareTableForTesting(
            'eloquent_storage_test_model',
            [
                'id' => [
                    'type' => 'integer',
                    'primary' => true,
                ],
                'name' => [
                    'type' => 'string',
                ],
                'test_date' => [
                    'type' => 'datetime',
                ],
            ]
        );
    }

    /**
     * Проверяет, что хранилище правильно распознает объект для обработки.
     */
    public function testSupports(): void
    {
        $model = new EloquentStorageTestModel();

        $storage = new EloquentStorage();

        $this->assertTrue($storage->supports($model));
    }

    /**
     * Проверяет, что хранилище правильно распознает объект для обработки.
     */
    public function testNotSupports(): void
    {
        $storage = new EloquentStorage();

        $this->assertFalse($storage->supports($this));
    }

    /**
     * Проверяет, что хранилище правильно распознает класс для обработки.
     */
    public function testSupportsClass(): void
    {
        $storage = new EloquentStorage();

        $this->assertTrue($storage->supportsClass(EloquentStorageTestModel::class));
    }

    /**
     * Проверяет, что хранилище правильно распознает класс для обработки.
     */
    public function testNotSupportsClass(): void
    {
        $storage = new EloquentStorage();

        $this->assertFalse($storage->supportsClass('test'));
    }

    /**
     * Проверяет, что объект верно вставит данные в хранилище.
     */
    public function testInsert(): void
    {
        $id = $this->createFakeData()->numberBetween(1, 1000);
        $name = $this->createFakeData()->word();
        $date = new DateTimeImmutable();
        $model = new EloquentStorageTestModel(
            [
                'id' => $id,
                'name' => $name,
                'test_date' => $date,
            ]
        );

        $id1 = $id + 1;
        $name1 = $this->createFakeData()->word();
        $date1 = new DateTimeImmutable();
        $model1 = new EloquentStorageTestModel(
            [
                'id' => $id1,
                'name' => $name1,
                'test_date' => $date1,
            ]
        );

        $id2 = $id + 2;
        $name2 = $this->createFakeData()->word();
        $date2 = '2021-10-10 10:10:10';
        $model2 = new EloquentStorageTestModel(
            [
                'id' => $id2,
                'name' => $name2,
                'test_date' => $date2,
            ]
        );

        $storage = new EloquentStorage(1);
        $storage->start();
        $storage->insert($model);
        $storage->insert($model1);
        $storage->insert($model2);
        $storage->stop();

        $this->assertDatabaseHasRow(
            'eloquent_storage_test_model',
            [
                'id' => $id,
                'name' => $name,
                'test_date' => $date,
            ]
        );
        $this->assertDatabaseHasRow(
            'eloquent_storage_test_model',
            [
                'id' => $id1,
                'name' => $name1,
                'test_date' => $date1,
            ]
        );
        $this->assertDatabaseHasRow(
            'eloquent_storage_test_model',
            [
                'id' => $id2,
                'name' => $name2,
                'test_date' => $date2,
            ]
        );
    }

    /**
     * Проверяет, что объект верно обработает ситуацию, когда один из объектов нельзя вставить.
     */
    public function testInsertFallback(): void
    {
        $id = $this->createFakeData()->numberBetween(1002, 2000);
        $name = $this->createFakeData()->word();
        $date = new DateTimeImmutable();
        $model = new EloquentStorageTestModel(
            [
                'id' => $id,
                'name' => $name,
                'test_date' => $date,
            ]
        );

        $model1 = new EloquentStorageTestModel(
            [
                'id' => null,
                'name' => null,
                'test_date' => null,
            ]
        );

        $storage = new EloquentStorage(1);
        $storage->start();
        $storage->insert($model);
        $storage->insert($model1);
        $storage->stop();

        $this->assertDatabaseHasRow(
            'eloquent_storage_test_model',
            [
                'id' => $id,
                'name' => $name,
                'test_date' => $date,
            ]
        );
    }

    /**
     * Проверяет, что объект выбросит исключение, если неверно указана модель для вставки.
     */
    public function testInsertWrongObjectException(): void
    {
        $storage = new EloquentStorage();

        $this->expectException(StorageException::class);

        $storage->start();
        $storage->insert($this);
        $storage->stop();
    }

    /**
     * Проверяет, что объект верно вставит или обновит данные в хранилище.
     */
    public function testUpsert(): void
    {
        $id = $this->createFakeData()->numberBetween(2002, 3000);
        $name = $this->createFakeData()->word();
        $date = new DateTimeImmutable('2020-10-10');
        $model = new EloquentStorageTestModel(
            [
                'id' => $id,
                'name' => $name,
                'test_date' => $date,
            ]
        );

        $name1 = $name . ' ' . $this->createFakeData()->word();
        $date1 = new DateTimeImmutable('2020-10-09');
        $model1 = new EloquentStorageTestModel(
            [
                'id' => $id,
                'name' => $name1,
                'test_date' => $date1,
            ]
        );

        $storage = new EloquentStorage();
        $storage->start();
        $storage->upsert($model);
        $storage->upsert($model1);
        $storage->stop();

        $this->assertDatabaseHasRow(
            'eloquent_storage_test_model',
            [
                'id' => $id,
                'name' => $name1,
                'test_date' => $date1,
            ]
        );
        $this->assertDatabaseDoesNotHaveRow(
            'eloquent_storage_test_model',
            [
                'name' => $name,
                'test_date' => $date,
            ]
        );
    }

    /**
     * Проверяет, что объект выбросит исключение, если неверно указана модель для обновления.
     */
    public function testUpsertWrongObjectException(): void
    {
        $storage = new EloquentStorage();

        $this->expectException(StorageException::class);

        $storage->start();
        $storage->upsert($this);
        $storage->stop();
    }

    /**
     * Проверяет, что объект верно вставит данные в хранилище.
     */
    public function testTruncate(): void
    {
        $id = $this->createFakeData()->numberBetween(3002, 4000);
        $model = new EloquentStorageTestModel(
            [
                'id' => $id,
                'name' => $this->createFakeData()->word(),
                'test_date' => new DateTimeImmutable(),
            ]
        );

        $id1 = $id + 1;
        $model1 = new EloquentStorageTestModel(
            [
                'id' => $id1,
                'name' => $this->createFakeData()->word(),
                'test_date' => new DateTimeImmutable(),
            ]
        );

        $storage = new EloquentStorage(1);
        $storage->start();
        $storage->insert($model);
        $storage->insert($model1);
        $storage->stop();

        $storage->truncate(EloquentStorageTestModel::class);

        $this->assertDatabaseDoesNotHaveRow(
            'eloquent_storage_test_model',
            [
                'id' => $id,
            ]
        );
        $this->assertDatabaseDoesNotHaveRow(
            'eloquent_storage_test_model',
            [
                'id' => $id1,
            ]
        );
    }

    /**
     * Проверяет, что объект выбросит исключение, если неверно указан класс для очистки таблицы.
     */
    public function testTruncateWrongClassException(): void
    {
        $storage = new EloquentStorage();

        $this->expectException(StorageException::class);

        $storage->truncate('test');
    }

    /**
     * Проверяет, что объект удалит данные из хранилища.
     */
    public function testDelete(): void
    {
        $id = $this->createFakeData()->numberBetween(4002, 5000);
        $model = new EloquentStorageTestModel(
            [
                'id' => $id,
                'name' => $this->createFakeData()->word(),
                'test_date' => new DateTimeImmutable(),
            ]
        );

        $storage = new EloquentStorage();
        $storage->start();
        $storage->insert($model);
        $storage->stop();

        $storage->delete($model);

        $this->assertDatabaseDoesNotHaveRow(
            'eloquent_storage_test_model',
            [
                'id' => $id,
            ]
        );
    }

    /**
     * Проверяет, что объект выбросит исключение, если неверно указан объект для удаления.
     */
    public function testDeleteWrongClassException(): void
    {
        $storage = new EloquentStorage();

        $this->expectException(StorageException::class);

        $storage->delete($this);
    }
}
