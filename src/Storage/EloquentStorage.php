<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Symfony\LiquetsoftFiasBundle\Storage;

use Illuminate\Database\Eloquent\Model;
use Liquetsoft\Fias\Component\Exception\StorageException;
use Liquetsoft\Fias\Component\Storage\Storage;
use Ramsey\Uuid\UuidInterface;
use DateTimeInterface;
use RuntimeException;
use Exception;
use Throwable;

/**
 * Объект, который сохраняет данные ФИАС с помощью Eloquent.
 */
class EloquentStorage implements Storage
{
    /**
     * Сохраненные в памяти данные для мнодественной вставки.
     *
     * Массив вида 'имя таблицы' => 'массив массивов данных для вставки'.
     *
     * @var mixed[]
     */
    protected $insertData = [];

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
        $meta = $this->em->getClassMetadata(get_class($entity));
        $table = $meta->getTableName();
        $fileds = $meta->getFieldNames();
        $insertArray = [];
        foreach ($fileds as $field) {
            $value = $meta->getFieldValue($entity, $field);
            if ($value instanceof DateTimeInterface) {
                $value = $value->format('Y-m-d H:i:s');
            } elseif ($value instanceof UuidInterface) {
                $value = $value->toString();
            }
            $column = $meta->getColumnName($field);
            $insertArray[$column] = $value;
        }
        $this->insertData[$table][] = $insertArray;
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
        foreach ($this->insertData as $tableName => $insertData) {
            if ($forceInsert || count($insertData) >= $this->insertBatch) {
                $this->bulkInsert($tableName, $insertData);
                unset($this->insertData[$tableName]);
            }
        }
    }

    /**
     * Отправляет запрос на массовую вставку данных в таблицу.
     *
     * @param string  $tableName
     * @param mixed[] $data
     *
     * @throws RuntimeException
     */
    protected function bulkInsert(string $tableName, array $data): void
    {
        try {
            $this->prepareAndRunBulkInsert($tableName, $data);
        } catch (UniqueConstraintViolationException $e) {
            $this->prepareAndRunBulkSafely($tableName, $data);
        }
    }

    /**
     * В случае исключения при множественной вставке, пробуем вставку по одной
     * записи, чтобы не откатывать весь блок записей.
     *
     * Только для некоторых случаев:
     *    - повторяющийся первичный ключ
     *
     * @param string  $table
     * @param mixed[] $data
     */
    protected function prepareAndRunBulkSafely(string $tableName, array $data): void
    {
        foreach ($data as $item) {
            try {
                $this->prepareAndRunBulkInsert($tableName, [$item]);
            } catch (Exception $e) {
                //@TODO залогировать исключение
            }
        }
    }

    /**
     * Непосредственное создание и запуск запроса на исполнение.
     *
     * @param string  $tableName
     * @param mixed[] $data
     *
     * @throws RuntimeException
     */
    protected function prepareAndRunBulkInsert(string $tableName, array $data): void
    {
        $dataSample = reset($data);
        $paramNames = implode(', ', array_keys($dataSample));
        $paramValues = implode(', ', array_fill(0, count($dataSample), '?'));
        $dataValues = '(' . implode('), (', array_fill(0, count($data), $paramValues)) . ')';
        $sql = "INSERT INTO {$tableName} ({$paramNames}) VALUES {$dataValues}";
        $stmt = $this->em->getConnection()->prepare($sql);
        $count = 0;
        foreach ($data as $item) {
            foreach ($item as $value) {
                $stmt->bindValue(++$count, $value);
            }
        }
        $stmt->execute();
    }

    /**
     * @inheritdoc
     */
    public function delete(object $entity): void
    {
        $this->checkIsEntityAllowedForEloquent($entity);

        try {
            $entity->refresh()->delete();
        } catch (Throwable $e) {
            throw new StorageException("Can't delete entity from storage.", 0, $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function upsert(object $entity): void
    {
        $this->checkIsEntityAllowedForEloquent($entity);

        try {
            $entity->refresh()->save();
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

        $entityClassName::query()->delete();
    }

    /**
     * ПРоверяет, что объект является моделью eloquent.
     *
     * @param object $entity
     *
     * @throws StorageException
     */
    protected function checkIsEntityAllowedForEloquent(object $entity): void
    {
        if (!($entity instanceof Model)) {
            throw new StorageException(
                "Entity must be instance of '" . Model::class
                . "', got '" . get_class($entity) . "'."
            );
        }
    }
}
