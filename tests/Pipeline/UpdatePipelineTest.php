<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Symfony\LiquetsoftFiasBundle\Tests\Serializer;

use DateTimeImmutable;
use Liquetsoft\Fias\Component\EntityDescriptor\BaseEntityDescriptor;
use Liquetsoft\Fias\Component\EntityField\BaseEntityField;
use Liquetsoft\Fias\Component\EntityManager\BaseEntityManager;
use Liquetsoft\Fias\Component\EntityRegistry\ArrayEntityRegistry;
use Liquetsoft\Fias\Component\FiasInformer\InformerResponse;
use Liquetsoft\Fias\Component\Pipeline\Pipe\ArrayPipe;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;
use Liquetsoft\Fias\Component\Pipeline\Task\CleanupTask;
use Liquetsoft\Fias\Component\Pipeline\Task\DataDeleteTask;
use Liquetsoft\Fias\Component\Pipeline\Task\DataUpsertTask;
use Liquetsoft\Fias\Component\Pipeline\Task\SelectFilesToProceedTask;
use Liquetsoft\Fias\Component\Pipeline\Task\Task;
use Liquetsoft\Fias\Component\Pipeline\Task\UnpackTask;
use Liquetsoft\Fias\Component\Pipeline\Task\VersionSetTask;
use Liquetsoft\Fias\Component\Unpacker\ZipUnpacker;
use Liquetsoft\Fias\Component\XmlReader\BaseXmlReader;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FiasVersion;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\FiasSerializer;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Storage\EloquentStorage;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\EloquentTestCase;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel\PipelineTestMockModel;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\VersionManager\EloquentVersionManager;
use SplFileInfo;

/**
 * Тест для объекта папйлайна для обновления базы данных.
 *
 * @internal
 */
class UpdatePipelineTest extends EloquentTestCase
{
    /**
     * Создает таблицу в бд перед тестами.
     */
    protected function setUp(): void
    {
        $this->prepareTableForTesting(
            'pipeline_test_model',
            [
                'testId' => [
                    'type' => 'integer',
                    'primary' => true,
                ],
                'testName' => [
                    'type' => 'string',
                ],
                'startdate' => [
                    'type' => 'datetime',
                ],
                'uuid' => [
                    'type' => 'string',
                ],
            ]
        );

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
     * Тест для проверки пайплайна с установкой ФИАС с ноля.
     */
    public function testUpdate(): void
    {
        $testDir = $this->getPathToTestDir();
        $testArchive = "{$testDir}/update.zip";
        copy(__DIR__ . '/_fixtures/update.zip', $testArchive);

        $version = $this->createFakeData()->numberBetween(1, 1000);
        $versionUrl = $this->createFakeData()->url;
        $versionInfo = $this->getMockBuilder(InformerResponse::class)->getMock();
        $versionInfo->method('getVersion')->willReturn($version);
        $versionInfo->method('getUrl')->willReturn($versionUrl);
        $versionInfo->method('hasResult')->willReturn(true);

        $state = new ArrayState();
        $state->setAndLockParameter(Task::DOWNLOAD_TO_FILE_PARAM, new SplFileInfo($testArchive));
        $state->setAndLockParameter(Task::EXTRACT_TO_FOLDER_PARAM, new SplFileInfo($testDir));
        $state->setAndLockParameter(Task::FIAS_INFO_PARAM, $versionInfo);

        $pipeline = $this->createPipeLine();
        $pipeline->run($state);

        $this->assertFileDoesNotExist($testArchive);
        $this->assertDatabaseHasRow(
            'fias_laravel_fias_version',
            [
                'version' => $version,
                'url' => $versionUrl,
            ]
        );
        $this->assertDatabaseHasRow(
            'pipeline_test_model',
            [
                'testId' => 555,
                'testName' => 'to insert',
                'startDate' => new DateTimeImmutable('2019-11-11 11:11:11'),
                'uuid' => '123e4567-e89b-12d3-a456-426655440005',
            ]
        );
        $this->assertDatabaseDoesNotHaveRow(
            'pipeline_test_model',
            [
                'testId' => 444,
            ]
        );
    }

    /**
     * Cоздает объект пайплайна для тестов.
     */
    private function createPipeLine(): Pipe
    {
        $fiasEntityRegistry = new ArrayEntityRegistry(
            [
                new BaseEntityDescriptor(
                    [
                        'name' => 'mock',
                        'xmlPath' => '/mockList/mock',
                        'insertFileMask' => 'AS_MOCK_*.XML',
                        'deleteFileMask' => 'AS_DEL_MOCK_*.XML',
                        'fields' => [
                            new BaseEntityField(
                                [
                                    'name' => 'testId',
                                    'type' => 'int',
                                    'isPrimary' => true,
                                ]
                            ),
                            new BaseEntityField(
                                [
                                    'name' => 'testName',
                                    'type' => 'string',
                                ]
                            ),
                            new BaseEntityField(
                                [
                                    'name' => 'startdate',
                                    'type' => 'string',
                                    'subType' => 'date',
                                ]
                            ),
                            new BaseEntityField(
                                [
                                    'name' => 'uuid',
                                    'type' => 'string',
                                    'subType' => 'uuid',
                                ]
                            ),
                        ],
                    ]
                ),
            ]
        );

        $fiasEntityManager = new BaseEntityManager(
            $fiasEntityRegistry,
            [
                'mock' => PipelineTestMockModel::class,
            ]
        );

        $storage = new EloquentStorage();

        $xmlReader = new BaseXmlReader();

        $serializer = new FiasSerializer();

        $versionManager = new EloquentVersionManager(FiasVersion::class);

        $tasks = [
            new UnpackTask(new ZipUnpacker()),
            new SelectFilesToProceedTask($fiasEntityManager),
            new DataUpsertTask($fiasEntityManager, $xmlReader, $storage, $serializer),
            new DataDeleteTask($fiasEntityManager, $xmlReader, $storage, $serializer),
            new VersionSetTask($versionManager),
        ];

        return new ArrayPipe($tasks, new CleanupTask());
    }
}
