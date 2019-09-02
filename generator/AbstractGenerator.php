<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator;

use SplFileInfo;
use InvalidArgumentException;

/**
 * Абстрактный класс для генераторов сущностей.
 */
abstract class AbstractGenerator
{
    /**
     * Проверяет, что каталог существует и доступен на запись.
     *
     * @param SplFileInfo $dir
     *
     * @throws InvalidArgumentException
     */
    protected function checkDir(SplFileInfo $dir): void
    {
        if (!$dir->isDir() || !$dir->isWritable()) {
            throw new InvalidArgumentException(
                "Destination folder '" . $dir->getPathname() . "' isn't writable or doesn't exist."
            );
        }
    }

    /**
     * Приводит пространсва имен к единообразному виду.
     *
     * @param string $namespace
     *
     * @return string
     */
    protected function unifyClassName(string $namespace): string
    {
        return ucfirst(trim($namespace, " \t\n\r\0\x0B\\"));
    }

    /**
     * Приводит пространства имен к единообразному виду.
     *
     * @param string $namespace
     *
     * @return string
     */
    protected function unifyNamespace(string $namespace): string
    {
        return trim($namespace, " \t\n\r\0\x0B\\");
    }

    /**
     * Приводит имена колонок к единообразному виду.
     *
     * @param string $name
     *
     * @return string
     */
    protected function unifyColumnName(string $name): string
    {
        return trim(strtolower(str_replace('_', '', $name)));
    }

    /**
     * Преобразует имя класса в имя таблицы в БД.
     *
     * @param string $name
     *
     * @return string
     */
    protected function convertClassnameToTableName(string $name): string
    {
        $tableName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));

        if (strpos($tableName, 'fias_laravel_') !== 0) {
            $tableName = 'fias_laravel_' . $tableName;
        }

        return $tableName;
    }
}
