<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Symfony\LiquetsoftFiasBundle\Tests\Serializer;

use Liquetsoft\Fias\Component\EntityDescriptor\BaseEntityDescriptor;
use Liquetsoft\Fias\Component\EntityField\BaseEntityField;
use Liquetsoft\Fias\Component\EntityManager\BaseEntityManager;
use Liquetsoft\Fias\Component\EntityRegistry\ArrayEntityRegistry;
use Liquetsoft\Fias\Component\FiasFileSelector\FiasFileSelectorArchive;
use Liquetsoft\Fias\Component\FilesDispatcher\FilesDispatcherImpl;
use Liquetsoft\Fias\Component\Pipeline\Pipe\ArrayPipe;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;
use Liquetsoft\Fias\Component\Pipeline\State\State;
use Liquetsoft\Fias\Component\Pipeline\State\StateParameter;
use Liquetsoft\Fias\Component\Pipeline\Task\ApplyNestedPipelineToFileTask;
use Liquetsoft\Fias\Component\Pipeline\Task\CleanupFilesUnpacked;
use Liquetsoft\Fias\Component\Pipeline\Task\CleanupTask;
use Liquetsoft\Fias\Component\Pipeline\Task\DataDeleteTask;
use Liquetsoft\Fias\Component\Pipeline\Task\DataUpsertTask;
use Liquetsoft\Fias\Component\Pipeline\Task\SelectFilesToProceedTask;
use Liquetsoft\Fias\Component\Pipeline\Task\Task;
use Liquetsoft\Fias\Component\Pipeline\Task\UnpackTask;
use Liquetsoft\Fias\Component\Pipeline\Task\VersionSetTask;
use Liquetsoft\Fias\Component\Unpacker\UnpackerZip;
use Liquetsoft\Fias\Component\XmlReader\BaseXmlReader;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FiasVersion;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\FiasSerializer;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Storage\EloquentStorage;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\EloquentTestCase;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel\PipelineTestMockModel;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\VersionManager\EloquentVersionManager;
use Marvin255\FileSystemHelper\FileSystemFactory;

/**
 * Тест для объекта папйлайна для обновления базы данных.
 *
 * @internal
 */
final class UpdatePipelineTest extends EloquentTestCase
{
    /**
     * Создает таблицу в бд перед тестами.
     */
    #[\Override]
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
                'stringCode' => [
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
     * Тест для проверки пайплайна с установкой ФИАС с ноля.
     */
    public function testUpdate(): void
    {
        $testDir = $this->getPathToTestDir();
        $testArchive = "{$testDir}/update.zip";
        copy(__DIR__ . '/_fixtures/update.zip', $testArchive);

        $version = 123;
        $versionFullUrl = 'https://test.test/full';
        $versionDeltaUrl = 'https://test.test/delta';

        $state = new ArrayState(
            [
                StateParameter::PATH_TO_DOWNLOAD_FILE->value => $testArchive,
                StateParameter::PATH_TO_EXTRACT_FOLDER->value => $testDir,
                StateParameter::PATH_TO_SOURCE->value => $testArchive,
                StateParameter::FIAS_NEXT_VERSION_NUMBER->value => $version,
                StateParameter::FIAS_NEXT_VERSION_FULL_URL->value => $versionFullUrl,
                StateParameter::FIAS_NEXT_VERSION_DELTA_URL->value => $versionDeltaUrl,
            ]
        );

        $pipeline = $this->createPipeLine();
        $pipeline->run($state);

        $this->assertFileDoesNotExist($testArchive);
        $this->assertDatabaseHasRow(
            'fias_laravel_fias_version',
            [
                'version' => $version,
            ]
        );
        $this->assertDatabaseHasRow(
            'pipeline_test_model',
            [
                'testId' => 555,
                'testName' => 'to insert',
                'startDate' => new \DateTimeImmutable('2019-11-11 11:11:11'),
                'uuid' => '123e4567-e89b-12d3-a456-426655440005',
                'stringCode' => '227010000010000016740025000000000',
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
        $fs = FileSystemFactory::create();
        $storage = new EloquentStorage();
        $unpacker = new UnpackerZip();
        $filesSelector = new FiasFileSelectorArchive($unpacker, $fiasEntityManager);
        $filesDispatcher = new FilesDispatcherImpl($fiasEntityManager);
        $xmlReader = new BaseXmlReader();
        $serializer = new FiasSerializer();
        $versionManager = new EloquentVersionManager(FiasVersion::class);

        $nestedTasksPipeline = new ArrayPipe(
            [
                new UnpackTask($unpacker),
                new DataUpsertTask($fiasEntityManager, $xmlReader, $storage, $serializer),
                new DataDeleteTask($fiasEntityManager, $xmlReader, $storage, $serializer),
            ],
            new CleanupFilesUnpacked($fs),
        );

        $dispatchFilesTask = new class($filesDispatcher) implements Task {
            public function __construct(private readonly FilesDispatcherImpl $filesDispatcher)
            {
            }

            /**
             * @psalm-suppress MixedArgument
             */
            #[\Override]
            public function run(State $state): State
            {
                $dispatchedFiles = $this->filesDispatcher->dispatch($state->getParameter(StateParameter::FILES_TO_PROCEED), 1);

                return $state->setParameter(StateParameter::FILES_TO_PROCEED, $dispatchedFiles[0]);
            }
        };

        $tasks = [
            new SelectFilesToProceedTask($filesSelector),
            $dispatchFilesTask,
            new ApplyNestedPipelineToFileTask($nestedTasksPipeline),
            new VersionSetTask($versionManager),
        ];

        return new ArrayPipe($tasks, new CleanupTask($fs));
    }
}
