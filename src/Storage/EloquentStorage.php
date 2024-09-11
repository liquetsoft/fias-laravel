<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Storage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Liquetsoft\Fias\Component\Exception\StorageException;
use Liquetsoft\Fias\Component\Storage\Storage;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

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
    private $insertBatch;

    /**
     * Объект для логгирования данных.
     *
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * Сохраненные в памяти данные для множественной вставки.
     *
     * Массив вида 'класс сущности => 'массив массивов данных для вставки'.
     *
     * @var array<string, array<int, array<string, mixed>>>
     */
    private $insertData = [];

    /**
     * Сохраненные в памяти данные для множественного обновления.
     *
     * Массив вида 'класс сущности => 'массив массивов данных для обновления'.
     *
     * @var array<string, array<string, array<string, mixed>>>
     */
    private $upsertData = [];

    /**
     * Список колонок для классов моделей.
     *
     * @var array<string, string[]>
     */
    private $columnsLists = [];

    /**
     * Флаг, который обозначает, что после завершения работы нужно включить
     * логгирование.
     *
     * @var bool
     */
    private $needToEnableLogging = false;

    public function __construct(int $insertBatch = 1000, ?LoggerInterface $logger = null)
    {
        $this->insertBatch = $insertBatch;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function stop(): void
    {
        $this->checkAndFlushInsert(true);
        $this->checkAndFlushUpsert(true);
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
     * {@inheritdoc}
     */
    public function supports(object $entity): bool
    {
        return $this->supportsClass(\get_class($entity));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass(string $class): bool
    {
        return is_subclass_of($class, Model::class);
    }

    /**
     * {@inheritdoc}
     */
    public function insert(object $entity): void
    {
        $model = $this->checkIsEntityAllowedForEloquent($entity);

        $class = \get_class($model);
        $this->insertData[$class][] = $this->collectValuesFromModel($model);

        $this->checkAndFlushInsert(false);
    }

    /**
     * {@inheritdoc}
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
        } catch (\Throwable $e) {
            throw new StorageException("Can't delete entity from storage", 0, $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function upsert(object $entity): void
    {
        $model = $this->checkIsEntityAllowedForEloquent($entity);

        $class = \get_class($model);
        $key = (string) $model->getKey();
        $this->upsertData[$class][$key] = $this->collectValuesFromModel($model);

        $this->checkAndFlushUpsert(false);
    }

    /**
     * {@inheritdoc}
     */
    public function truncate(string $entityClassName): void
    {
        if (!class_exists($entityClassName) || !is_subclass_of($entityClassName, Model::class)) {
            throw new StorageException(
                "Entity class for truncating must exists and extends '" . Model::class . "' got '{$entityClassName}'"
            );
        }

        try {
            $entityClassName::query()->delete();
        } catch (\Throwable $e) {
            throw new StorageException("Can't truncate storage", 0, $e);
        }
    }

    /**
     * Проверяет нужно ли отправлять запросы на множественные вставки элементов,
     * сохраненых в памяти.
     *
     * @throws StorageException
     */
    private function checkAndFlushInsert(bool $forceInsert = false): void
    {
        foreach ($this->insertData as $className => $insertData) {
            if ($forceInsert || \count($insertData) >= $this->insertBatch) {
                $this->bulkInsert($className, $insertData);
                unset($this->insertData[$className]);
            }
        }
    }

    /**
     * Проверяет нужно ли отправлять запросы на множественные вставки элементов,
     * сохраненых в памяти.
     *
     * @throws StorageException
     *
     * @psalm-suppress InvalidStringClass
     */
    private function checkAndFlushUpsert(bool $forceUpsert = false): void
    {
        foreach ($this->upsertData as $className => $upsertData) {
            if (!$forceUpsert && \count($upsertData) < $this->insertBatch) {
                continue;
            }

            /** @var iterable<Model> */
            $existedModels = $className::findMany(array_keys($upsertData));
            $existedModelsByPrimary = [];
            foreach ($existedModels as $model) {
                $existedModelsByPrimary[(string) $model->getKey()] = $model;
            }

            $toInsert = [];
            foreach ($upsertData as $key => $upsertItem) {
                if (isset($existedModelsByPrimary[$key])) {
                    $persistedModel = $existedModelsByPrimary[$key];
                    $persistedModel->fill($upsertItem);
                    try {
                        $persistedModel->save();
                    } catch (\Throwable $e) {
                        throw new StorageException("Can't update item in storage", 0, $e);
                    }
                } else {
                    $toInsert[] = $upsertItem;
                }
            }

            if (!empty($toInsert)) {
                $this->bulkInsert($className, $toInsert);
            }

            unset($this->upsertData[$className]);
        }
    }

    /**
     * Проверяет, что объект является моделью eloquent.
     *
     * @throws StorageException
     */
    private function checkIsEntityAllowedForEloquent(object $entity): Model
    {
        if (!($entity instanceof Model)) {
            throw new StorageException(
                "Entity must be instance of '" . Model::class . "', got '" . \get_class($entity) . "'"
            );
        }

        return $entity;
    }

    /**
     * Возвращает массив значений модели для вставки в таблицу.
     *
     * @return array<string, mixed>
     */
    private function collectValuesFromModel(Model $entity): array
    {
        $columns = $this->getColumnsListForModel($entity);

        $item = [];
        $entityAttributes = $entity->getAttributes();
        foreach ($columns as $column) {
            $columnValue = $entityAttributes[$column] ?? null;
            if ($columnValue instanceof \DateTimeInterface) {
                $columnValue = $columnValue->format('Y-m-d H:i:s');
            }
            $item[$column] = $columnValue;
        }

        return $item;
    }

    /**
     * Возвращает список колонок для таблицы, которой соответствует указанная модель.
     *
     * @return string[]
     */
    private function getColumnsListForModel(Model $model): array
    {
        $class = \get_class($model);

        if (!isset($this->columnsLists[$class])) {
            /** @var string[] */
            $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
            $this->columnsLists[$class] = $columns;
        }

        return $this->columnsLists[$class];
    }

    /**
     * Отправляет запрос на массовую вставку данных в таблицу.
     *
     * @param mixed[] $data
     *
     * @throws StorageException
     *
     * @psalm-suppress InvalidStringClass
     */
    private function bulkInsert(string $className, array $data): void
    {
        try {
            $className::insert($data);
        } catch (\Throwable $e) {
            $this->bulkInsertFallback($className, $data);
        }
    }

    /**
     * Фоллбэк на случай, если при записи бандла произошла ошибка. Пробуем сохранить все записи по одной.
     *
     * @param mixed[] $data
     *
     * @throws StorageException
     *
     * @psalm-suppress InvalidStringClass
     */
    private function bulkInsertFallback(string $className, array $data): void
    {
        foreach ($data as $item) {
            try {
                $className::insert([$item]);
            } catch (\Throwable $e) {
                $this->log(
                    LogLevel::ERROR,
                    "Error while inserting item of class '{$className}' to eloquent storage. Item wasn't proceed",
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
     */
    private function log(string $errorLevel, string $message, array $context = []): void
    {
        if ($this->logger) {
            $this->logger->log($errorLevel, $message, $context);
        }
    }
}
