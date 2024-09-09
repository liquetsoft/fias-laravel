<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\VersionManager;

use Liquetsoft\Fias\Component\FiasInformer\FiasInformerResponse;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FiasVersion;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\EloquentTestCase;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\VersionManager\EloquentVersionManager;

/**
 * Класс для проверки менеджера версий ФИАС.
 *
 * @internal
 */
final class EloquentVersionManagerTest extends EloquentTestCase
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
                'fullurl' => [
                    'type' => 'string',
                ],
                'deltaurl' => [
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
        $version = 123;
        $fullUrl = 'https://test.test/full';
        $deltaUrl = 'https://test.test/delta';

        $info = $this->mock(FiasInformerResponse::class);
        $info->expects($this->any())->method('getVersion')->willReturn($version);
        $info->expects($this->any())->method('getFullUrl')->willReturn($fullUrl);
        $info->expects($this->any())->method('getDeltaUrl')->willReturn($deltaUrl);

        $versionManager = new EloquentVersionManager(FiasVersion::class);
        $versionManager->setCurrentVersion($info);

        $this->assertDatabaseHasRow(
            'fias_laravel_fias_version',
            [
                'version' => $version,
                'fullurl' => $fullUrl,
                'deltaurl' => $deltaUrl,
            ]
        );
    }

    /**
     * Проверяет, что объект правильно получает текущую версию.
     */
    public function testGetCurrentVersion(): void
    {
        $version = 123;
        $fullUrl = 'https://test.test/full';
        $deltaUrl = 'https://test.test/delta';

        $info = $this->mock(FiasInformerResponse::class);
        $info->expects($this->any())->method('getVersion')->willReturn($version);
        $info->expects($this->any())->method('getFullUrl')->willReturn($fullUrl);
        $info->expects($this->any())->method('getDeltaUrl')->willReturn($deltaUrl);

        $versionManager = new EloquentVersionManager(FiasVersion::class);
        $versionManager->setCurrentVersion($info);
        $versionResponse = $versionManager->getCurrentVersion();

        $this->assertSame($version, $versionResponse->getVersion());
        $this->assertSame($fullUrl, $versionResponse->getFullUrl());
        $this->assertSame($deltaUrl, $versionResponse->getDeltaUrl());
    }

    /**
     * Проверяет, что объект выбросит исключение, если задан неверный класс сущности.
     */
    public function testSetCurrentVersionWrongEntityException(): void
    {
        $info = $this->mock(FiasInformerResponse::class);

        $versionManager = new EloquentVersionManager('test');

        $this->expectException(\RuntimeException::class);
        $versionManager->setCurrentVersion($info);
    }
}
