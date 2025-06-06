<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests;

use Faker\Factory;
use Faker\Generator;
use Marvin255\FileSystemHelper\FileSystemFactory;
use Marvin255\FileSystemHelper\FileSystemHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Базовый класс для всех тестов.
 */
abstract class BaseCase extends TestCase
{
    private ?Generator $faker = null;

    private ?FileSystemHelper $fs = null;

    private ?string $tempDir = null;

    /**
     * Возвращает объект php faker для генерации случайных данных.
     *
     * Использует ленивую инициализацию и создает объект faker только при первом
     * запросе, для всех последующих запросов возвращает тот же самый инстанс,
     * который был создан в первый раз.
     */
    public function createFakeData(): Generator
    {
        if ($this->faker === null) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }

    /**
     * Возвращает объект для работы с файловой системой.
     */
    public function fs(): FileSystemHelper
    {
        if ($this->fs === null) {
            $this->fs = FileSystemFactory::create();
        }

        return $this->fs;
    }

    /**
     * Возвращает путь до базовой папки для тестов.
     */
    protected function getTempDir(): string
    {
        if ($this->tempDir === null) {
            $this->tempDir = sys_get_temp_dir();
            if (!$this->tempDir || !is_writable($this->tempDir)) {
                throw new \RuntimeException(
                    "Can't find or write temporary folder: {$this->tempDir}"
                );
            }
            $this->tempDir .= \DIRECTORY_SEPARATOR . 'fias_component';
            $this->fs()->mkdirIfNotExist($this->tempDir);
            $this->fs()->emptyDir($this->tempDir);
        }

        return $this->tempDir;
    }

    /**
     * Создает тестовую директорию во временной папке и возвращает путь до нее.
     */
    protected function getPathToTestDir(string $name = ''): string
    {
        if ($name === '') {
            $name = $this->createFakeData()->word();
        }

        $pathToFolder = $this->getTempDir() . \DIRECTORY_SEPARATOR . $name;

        $this->fs()->mkdir($pathToFolder);

        return $pathToFolder;
    }

    /**
     * Создает тестовый файл во временной директории.
     */
    protected function getPathToTestFile(string $name = '', ?string $content = null): string
    {
        if ($name === '') {
            $name = $this->createFakeData()->word() . '.txt';
        }

        $pathToFile = $this->getTempDir() . \DIRECTORY_SEPARATOR . $name;
        $content = $content === null ? $this->createFakeData()->word() : $content;
        if (file_put_contents($pathToFile, $content) === false) {
            throw new \RuntimeException("Can't create file {$pathToFile}");
        }

        return $pathToFile;
    }

    /**
     * Удаляет тестовую директорию и все ее содержимое.
     */
    #[\Override]
    protected function tearDown(): void
    {
        if ($this->tempDir !== null) {
            $this->fs()->remove($this->tempDir);
        }

        parent::tearDown();
    }

    /**
     * @template T
     *
     * @param class-string<T> $className
     *
     * @return MockObject&T
     */
    protected function mock(string $className): MockObject
    {
        $mock = $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock();

        return $mock;
    }
}
