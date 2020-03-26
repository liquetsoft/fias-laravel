<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Storage;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Liquetsoft\Fias\Component\Exception\StorageException;
use Liquetsoft\Fias\Component\Storage\Storage;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Throwable;

/**
 * Объект, который сохраняет данные ФИАС с помощью Eloquent.
 */
class EloquentStorage implements Storage
{
    /**
     * Размер стека для одномоментной вставки.
     *
     * @var int
     */
    protected $insertBatch;

    /**
     * Объект для логгирования данных.
     *
     * @var LoggerInterface|null
     */
    protected $logger;

    /**
     * Сохраненные в памяти данные для множественной вставки.
     *
     * Массив вида 'класс сущности => 'массив массивов данных для вставки'.
     *
     * @var array<string, array>
     */
    protected $insertData = [];

    /**
     * Список колонок для классов моделей.
     *
     * @var array<string, array>
     */
    protected $columnsLists = [];

    /**
     * Флаг, который обозначает, что после завершения работы нужно включить
     * логгирование.
     *
     * @var bool
     */
    protected $needToEnableLogging = false;

    /**
     * @param int                  $insertBatch
     * @param LoggerInterface|null $logger
     */
    public function __construct(int $insertBatch = 1000, ?LoggerInterface $logger = null)
    {
        $this->insertBatch = $insertBatch;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function start(): void
    {
        $connection = DB::connection();
        if (
            method_exists($connection, 'disableQueryLog')
            && method_exists($connection, 'logging')
            && $connection->logging() === true
        ) {
            $this->needToEnableLogging = true;
            $connection->disableQueryLog();
        }
    }

    /**
     * @inheritdoc
     */
    public function stop(): void
    {
        $this->checkAndFlushInsert(true);

        $this->insertData = [];
        $this->columnsLists = [];

        $connection = DB::connection();
        if (
            $this->needToEnableLogging
            && method_exists($connection, 'enableQueryLog')
        ) {
            $this->needToEnableLogging = false;
            $connection->enableQueryLog();
        }
    }

    /**
     * @inheritdoc
     */
    public function supports(object $entity): bool
    {
        return $this->supportsClass(get_class($entity));
    }

    /**
     * @inheritdoc
     */
    public function supportsClass(string $class): bool
    {
        return is_subclass_of($class, Model::class);
    }

    /**
     * @inheritdoc
     */
    public function insert(object $entity): void
    {
        $model = $this->checkIsEntityAllowedForEloquent($entity);

        $class = get_class($model);
        $this->insertData[$class][] = $this->collectValuesFromModel($model);

        $this->checkAndFlushInsert(false);
    }

    /**
     * @inheritdoc
     */
    public function delete(object $entity): void
    {
        $model = $this->checkIsEntityAllowedForEloquent($entity);

        try {
            /** @var Model|null $persistedModel */
            $persistedModel = $model->query()->find($model->getKey());
            if ($persistedModel instanceof Model) {
                $persistedModel->delete();
            }
            unset($persistedModel);
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
            /** @var Model $persistedModel */
            $persistedModel = $model->query()->findOrNew($model->getKey());
            $persistedModel->fill($model->getAttributes());
            $persistedModel->save();
            unset($persistedModel);
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
     * Возвращает массив значений модели для вставки в таблицу.
     *
     * @param Model $entity
     *
     * @return array
     */
    protected function collectValuesFromModel(Model $entity): array
    {
        $columns = $this->getColumnsListForModel($entity);

        $item = [];
        foreach ($columns as $column) {
            $columnValue = $entity->getAttribute($column);
            if ($columnValue instanceof DateTimeInterface) {
                $columnValue = $columnValue->format('Y-m-d H:i:s');
            }
            $item[$column] = $columnValue;
        }

        return $item;
    }

    /**
     * Возвращает список колонок для таблицы, которой соответствует указанная модель.
     *
     * @param Model $model
     *
     * @return string[]
     */
    protected function getColumnsListForModel(Model $model): array
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

    /**
     * Проверяет нужно ли отправлять запросы на множественные вставки элементов,
     * сохраненых в памяти.
     *
     * @param bool $forceInsert
     *
     * @throws StorageException
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
     * @throws StorageException
     */
    protected function bulkInsert(string $className, array $data): void
    {
        if (!class_exists($className)) {
            throw new StorageException("'{$className}' is not a class name.");
        }

        try {
            $className::insert($data);
        } catch (Throwable $e) {
            $this->bulkInsertFallback($className, $data);
        }
    }

    /**
     * Фоллбэк на случай, если при записи бандла произошла ошибка. Пробуем сохранить все записи по одной.
     *
     * @param string  $className
     * @param mixed[] $data
     *
     * @throws StorageException
     */
    protected function bulkInsertFallback(string $className, array $data): void
    {
        if (!class_exists($className)) {
            throw new StorageException("'{$className}' is not a class name.");
        }

        foreach ($data as $item) {
            try {
                $className::insert([$item]);
            } catch (Throwable $e) {
                $this->log(
                    LogLevel::ERROR,
                    "Error while inserting item of class '{$className}' to eloquent storage. Item wasn't proceed.",
                    [
                        'item' => $item,
                        'error_message' => $e->getMessage(),
                    ]
                );
            }
        }
    }

    /**
     * Запись сообщения в лог.
     *
     * @param string $errorLevel
     * @param string $message
     * @param array  $context
     */
    protected function log(string $errorLevel, string $message, array $context = []): void
    {
        if ($this->logger) {
            $this->logger->log($errorLevel, $message, $context);
        }
    }
}
