<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Storage;

use Illuminate\Database\Eloquent\Model;
use Liquetsoft\Fias\Component\Exception\StorageException;
use Liquetsoft\Fias\Component\Storage\Storage;
use RuntimeException;
use Throwable;

/**
 * Объект, который сохраняет данные ФИАС с помощью Eloquent.
 */
class EloquentStorage implements Storage
{
    /**
     * Сохраненные в памяти данные для множественной вставки.
     *
     * Массив вида 'класс сущности => 'массив массивов данных для вставки'.
     *
     * @var array<string, array>
     */
    protected $insertData = [];

    /**
     * Размер стека для одномоментной вставки.
     *
     * @var int
     */
    protected $insertBatch;

    /**
     * Список колонок для классов моделей.
     *
     * @var array<string, array>
     */
    protected $columnsLists = [];

    /**
     * @param int $insertBatch
     */
    public function __construct(int $insertBatch = 1000)
    {
        $this->insertBatch = $insertBatch;
    }

    /**
     * @inheritdoc
     */
    public function start(): void
    {
    }

    /**
     * @inheritdoc
     */
    public function stop(): void
    {
        $this->checkAndFlushInsert(true);
    }

    /**
     * @inheritdoc
     */
    public function insert(object $entity): void
    {
        $model = $this->checkIsEntityAllowedForEloquent($entity);

        $class = get_class($model);
        $columns = $this->getColumsListForModel($model);
        $item = [];
        foreach ($columns as $column) {
            $item[$column] = $entity->getAttribute($column);
        }
        $this->insertData[$class][] = $item;

        $this->checkAndFlushInsert(false);
    }

    /**
     * Проверяет нужно ли отправлять запросы на множественные вставки элементов,
     * сохраненых в памяти.
     *
     * @param bool $forceInsert
     */
    protected function checkAndFlushInsert(bool $forceInsert = false): void
    {
        foreach ($this->insertData as $className => $insertData) {
            if ($forceInsert || count($insertData) >= $this->insertBatch) {
                $this->bulkInsert($className, $insertData);
                unset($this->insertData[$className]);
            }
        }
    }

    /**
     * Отправляет запрос на массовую вставку данных в таблицу.
     *
     * @param string  $className
     * @param mixed[] $data
     *
     * @throws RuntimeException
     */
    protected function bulkInsert(string $className, array $data): void
    {
        if (class_exists($className)) {
            $className::insert($data);
        } else {
            throw new RuntimeException("'{$className}' is not a class name.");
        }
    }

    /**
     * @inheritdoc
     */
    public function delete(object $entity): void
    {
        $model = $this->checkIsEntityAllowedForEloquent($entity);

        try {
            $model->refresh()->delete();
        } catch (Throwable $e) {
            throw new StorageException("Can't delete entity from storage.", 0, $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function upsert(object $entity): void
    {
        $model = $this->checkIsEntityAllowedForEloquent($entity);

        try {
            $model->refresh()->save();
        } catch (Throwable $e) {
            throw new StorageException("Can't update or insert entity in storage.", 0, $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function truncate(string $entityClassName): void
    {
        if (!class_exists($entityClassName) || !is_subclass_of($entityClassName, Model::class)) {
            throw new StorageException(
                "Entity class for truncating must exists and extends '" . Model::class . "'"
                . "got '{$entityClassName}'."
            );
        }

        try {
            $entityClassName::query()->delete();
        } catch (Throwable $e) {
            throw new StorageException("Can't truncate storage.", 0, $e);
        }
    }

    /**
     * Проверяет, что объект является моделью eloquent.
     *
     * @param object $entity
     *
     * @return Model
     *
     * @throws StorageException
     */
    protected function checkIsEntityAllowedForEloquent(object $entity): Model
    {
        if (!($entity instanceof Model)) {
            throw new StorageException(
                "Entity must be instance of '" . Model::class
                . "', got '" . get_class($entity) . "'."
            );
        }

        return $entity;
    }

    /**
     * Возвращает список колонок для таблицы, которой соответствует указанная модель.
     *
     * @param Model $model
     *
     * @return string[]
     */
    protected function getColumsListForModel(Model $model): array
    {
        $class = get_class($model);

        if (!isset($this->columnsLists[$class])) {
            $this->columnsLists[$class] = $model->getConnection()
                ->getSchemaBuilder()
                ->getColumnListing($model->getTable())
            ;
        }

        return $this->columnsLists[$class];
    }
}
