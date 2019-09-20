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
        $this->checkIsEntityAllowedForEloquent($entity);

        $class = get_class($entity);
        $this->insertData[$class][] = $entity->getAttributes();

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
