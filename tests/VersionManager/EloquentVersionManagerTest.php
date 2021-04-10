<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\VersionManager;

use Liquetsoft\Fias\Component\FiasInformer\InformerResponse;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FiasVersion;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\EloquentTestCase;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\VersionManager\EloquentVersionManager;
use RuntimeException;

/**
 * Класс для проверки менеджера версий ФИАС.
 *
 * @internal
 */
class EloquentVersionManagerTest extends EloquentTestCase
{
    /**
     * Создает таблицу в бд перед тестами.
     */
    protected function setUp(): void
    {
        $this->prepareTableForTesting(
            'fias_laravel_fias_version',
            [
                'version' => [
                    'type' => 'integer',
                    'primary' => true,
                ],
                'url' => [
                    'type' => 'string',
                ],
                'created_at' => [
                    'type' => 'datetime',
                ],
            ]
        );
    }

    /**
     * Проверяет, что объект верно задает текущую версию ФИАС.
     */
    public function testSetCurrentVersion(): void
    {
        $version = $this->createFakeData()->numberBetween(1, 1000);
        $url = $this->createFakeData()->url;

        $info = $this->getMockBuilder(InformerResponse::class)->getMock();
        $info->method('getVersion')->willReturn($version);
        $info->method('getUrl')->willReturn($url);

        $versionManager = new EloquentVersionManager(FiasVersion::class);
        $versionManager->setCurrentVersion($info);

        $this->assertDatabaseHasRow(
            'fias_laravel_fias_version',
            [
                'version' => $version,
                'url' => $url,
            ]
        );
    }

    /**
     * Проверяет, что объект выбросит исключение, если задан неверный класс сущности.
     */
    public function testSetCurrentVersionWrongEntityException(): void
    {
        $info = $this->getMockBuilder(InformerResponse::class)->getMock();

        $versionManager = new EloquentVersionManager('test');

        $this->expectException(RuntimeException::class);
        $versionManager->setCurrentVersion($info);
    }

    /**
     * Проверяет, что объект правильно получает текущую версию.
     */
    public function testGetCurrentVersion(): void
    {
        $version = $this->createFakeData()->numberBetween(1, 1000);
        $url = $this->createFakeData()->url;

        $info = $this->getMockBuilder(InformerResponse::class)->getMock();
        $info->method('getVersion')->willReturn($version);
        $info->method('getUrl')->willReturn($url);

        $versionManager = new EloquentVersionManager(FiasVersion::class);
        $versionManager->setCurrentVersion($info);

        $versionResponse = $versionManager->getCurrentVersion();

        $this->assertSame($version, $versionResponse->getVersion());
        $this->assertSame($url, $versionResponse->getUrl());
    }

    /**
     * Проверяет, что объект выбросит исключение, если задан неверный класс сущности.
     */
    public function testGetCurrentVersionWrongEntityException(): void
    {
        $versionManager = new EloquentVersionManager('test');

        $this->expectException(RuntimeException::class);
        $versionResponse = $versionManager->getCurrentVersion();
    }
}
