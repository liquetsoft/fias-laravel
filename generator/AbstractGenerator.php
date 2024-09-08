<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator;

use Liquetsoft\Fias\Component\EntityDescriptor\EntityDescriptor;
use Liquetsoft\Fias\Component\EntityRegistry\EntityRegistry;

/**
 * Абстрактный класс для генераторов сущностей.
 */
abstract class AbstractGenerator
{
    /**
     * @var EntityRegistry
     */
    protected $registry;

    /**
     * Создает php класс для указанного дескриптора.
     *
     * @throws \Throwable
     */
    abstract protected function generateClassByDescriptor(EntityDescriptor $descriptor, \SplFileInfo $dir, string $namespace): void;

    public function __construct(EntityRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * Создает классы сущностей в указанной папке с указанным пространством имен.
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function run(\SplFileInfo $dir, string $namespace = ''): void
    {
        $this->checkDir($dir);
        $unifiedNamespace = $this->unifyNamespace($namespace);

        try {
            $this->generate($dir, $unifiedNamespace);
        } catch (\Throwable $e) {
            $message = 'Error while class generation.';
            throw new \RuntimeException($message, 0, $e);
        }
    }

    /**
     * Процесс генерации классов.
     *
     * @throws \Throwable
     */
    protected function generate(\SplFileInfo $dir, string $namespace): void
    {
        $descriptors = $this->registry->getDescriptors();
        foreach ($descriptors as $descriptor) {
            $this->generateClassByDescriptor($descriptor, $dir, $namespace);
        }
    }

    /**
     * Проверяет, что каталог существует и доступен на запись.
     *
     * @throws \InvalidArgumentException
     */
    protected function checkDir(\SplFileInfo $dir): void
    {
        if (!$dir->isDir() || !$dir->isWritable()) {
            throw new \InvalidArgumentException(
                "Destination folder '" . $dir->getPathname() . "' isn't writable or doesn't exist."
            );
        }
    }

    /**
     * Приводит пространсва имен к единообразному виду.
     */
    protected function unifyClassName(string $namespace): string
    {
        $name = strtolower(trim($namespace, " \t\n\r\0\x0B\\"));
        $arName = array_map('ucfirst', explode('_', $name));

        return implode('', $arName);
    }

    /**
     * Приводит пространства имен к единообразному виду.
     */
    protected function unifyNamespace(string $namespace): string
    {
        return trim($namespace, " \t\n\r\0\x0B\\");
    }

    /**
     * Приводит имена колонок к единообразному виду.
     */
    protected function unifyColumnName(string $name): string
    {
        return trim(strtolower($name));
    }

    /**
     * Преобразует имя класса в имя таблицы в БД.
     */
    protected function convertClassnameToTableName(string $name): string
    {
        $name = $this->unifyClassName($name);
        $tableName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));

        if (strpos($tableName, 'fias_laravel_') !== 0) {
            $tableName = 'fias_laravel_' . $tableName;
        }

        return $tableName;
    }
}
