<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Liquetsoft\Fias\Component\Downloader\Downloader;
use Liquetsoft\Fias\Component\Downloader\DownloaderImpl;
use Liquetsoft\Fias\Component\EntityManager\BaseEntityManager;
use Liquetsoft\Fias\Component\EntityManager\EntityManager;
use Liquetsoft\Fias\Component\EntityRegistry\EntityRegistry;
use Liquetsoft\Fias\Component\EntityRegistry\PhpArrayFileRegistry;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformer;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformerImpl;
use Liquetsoft\Fias\Component\FiasStatusChecker\FiasStatusChecker;
use Liquetsoft\Fias\Component\FiasStatusChecker\FiasStatusCheckerImpl;
use Liquetsoft\Fias\Component\FilesDispatcher\EntityFileDispatcher;
use Liquetsoft\Fias\Component\FilesDispatcher\FilesDispatcher;
use Liquetsoft\Fias\Component\Filter\Filter;
use Liquetsoft\Fias\Component\Filter\RegexpFilter;
use Liquetsoft\Fias\Component\HttpTransport\HttpTransport;
use Liquetsoft\Fias\Component\HttpTransport\HttpTransportCurl;
use Liquetsoft\Fias\Component\Pipeline\Pipe\ArrayPipe;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\Task\CheckStatusTask;
use Liquetsoft\Fias\Component\Pipeline\Task\CleanupTask;
use Liquetsoft\Fias\Component\Pipeline\Task\DataDeleteTask;
use Liquetsoft\Fias\Component\Pipeline\Task\DataInsertTask;
use Liquetsoft\Fias\Component\Pipeline\Task\DataUpsertTask;
use Liquetsoft\Fias\Component\Pipeline\Task\DownloadTask;
use Liquetsoft\Fias\Component\Pipeline\Task\InformDeltaTask;
use Liquetsoft\Fias\Component\Pipeline\Task\InformFullTask;
use Liquetsoft\Fias\Component\Pipeline\Task\PrepareFolderTask;
use Liquetsoft\Fias\Component\Pipeline\Task\ProcessSwitchTask;
use Liquetsoft\Fias\Component\Pipeline\Task\SelectFilesToProceedTask;
use Liquetsoft\Fias\Component\Pipeline\Task\Task;
use Liquetsoft\Fias\Component\Pipeline\Task\TruncateTask;
use Liquetsoft\Fias\Component\Pipeline\Task\UnpackTask;
use Liquetsoft\Fias\Component\Pipeline\Task\VersionGetTask;
use Liquetsoft\Fias\Component\Pipeline\Task\VersionSetTask;
use Liquetsoft\Fias\Component\Storage\CompositeStorage;
use Liquetsoft\Fias\Component\Storage\Storage;
use Liquetsoft\Fias\Component\Unpacker\Unpacker;
use Liquetsoft\Fias\Component\Unpacker\ZipUnpacker;
use Liquetsoft\Fias\Component\VersionManager\VersionManager;
use Liquetsoft\Fias\Component\XmlReader\BaseXmlReader;
use Liquetsoft\Fias\Component\XmlReader\XmlReader;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\DownloadCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\InstallCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\InstallFromFolderCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\InstallParallelRunningCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\StatusCheckCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\TruncateCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\UpdateCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\UpdateFromFolderCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\UpdateParallelRunningCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\VersionsCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\VersionSetCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\FiasSerializer;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Storage\EloquentStorage;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\VersionManager\EloquentVersionManager;
use Marvin255\FileSystemHelper\FileSystemFactory;
use Marvin255\FileSystemHelper\FileSystemHelperInterface;
use Psr\Log\LoggerInterface;

/**
 * Service provider для модуля.
 */
final class LiquetsoftFiasBundleServiceProvider extends ServiceProvider
{
    private string $bundlePrefix = 'liquetsoft_fias';

    /**
     * Регистрирует сервисы модуля в приложении.
     */
    public function register(): void
    {
        $descriptions = $this->getServicesDescriptions();
        foreach ($descriptions as $key => $description) {
            if (strpos($key, '#') !== false) {
                [$key, $tag] = explode('#', $key);
            } else {
                $tag = null;
            }
            $this->app->singleton($key, $description);
            if ($tag !== null) {
                $this->app->tag([$key], $tag);
            }
        }

        $this->mergeConfigFrom(
            __DIR__ . "/Config/{$this->prefixString('php')}", $this->bundlePrefix
        );
    }

    /**
     * Загружает данныем модуля в приложение.
     */
    public function boot(): void
    {
        if ($this->getOptionBool('allow_bundle_migrations')) {
            $this->loadMigrationsFrom(__DIR__ . '/Migration');
        }

        $this->publishes(
            [
                __DIR__ . "/Config/{$this->prefixString('php')}" => config_path($this->prefixString('php')),
            ]
        );

        if ($this->app->runningInConsole()) {
            $this->commands(
                [
                    InstallCommand::class,
                    InstallFromFolderCommand::class,
                    InstallParallelRunningCommand::class,
                    UpdateCommand::class,
                    UpdateFromFolderCommand::class,
                    UpdateParallelRunningCommand::class,
                    TruncateCommand::class,
                    VersionsCommand::class,
                    VersionSetCommand::class,
                    DownloadCommand::class,
                    StatusCheckCommand::class,
                ]
            );
        }
    }

    /**
     * Возвращает массив сервисов с их определениями.
     *
     * @return array<string, \Closure|string>
     */
    private function getServicesDescriptions(): array
    {
        $servicesList = [];

        $this->registerServices($servicesList);
        $this->registerTasks($servicesList);
        $this->registerPipelines($servicesList);

        return $servicesList;
    }

    /**
     * Регистрирует сервисы бандла.
     *
     * @param array<string, \Closure|string> $servicesList
     */
    private function registerServices(array &$servicesList): void
    {
        // Объект для работы с файловой системой
        $servicesList[FileSystemHelperInterface::class] = fn (): FileSystemHelperInterface => FileSystemFactory::create();

        // http клиент
        $servicesList[HttpTransport::class] = HttpTransportCurl::class;

        // объект, который получает ссылку на ФИАС через http-клиент
        $servicesList[FiasInformer::class] = FiasInformerImpl::class;

        // объект, который проверяет статус ФИАС
        $servicesList[FiasStatusChecker::class] = FiasStatusCheckerImpl::class;

        // объект, который загружает файлы
        $servicesList[Downloader::class] = function (Application $app): Downloader {
            return new DownloaderImpl(
                $app->get(HttpTransport::class),
                $this->getOptionInt('download_retry_attempts')
            );
        };

        // объект, который распаковывает архивы
        $servicesList[Unpacker::class] = ZipUnpacker::class;

        // объект, который читает xml из файла
        $servicesList[XmlReader::class] = BaseXmlReader::class;

        // сериалайзер, который преобразует xml для единичной записи в объект
        $servicesList[$this->prefixString('serializer.serializer')] = FiasSerializer::class;

        // объект с описаниями сущностей ФИАС
        $servicesList[EntityRegistry::class] = function (): EntityRegistry {
            return new PhpArrayFileRegistry(
                $this->getOptionString('registry_path') ?: null
            );
        };

        // объект, который определяет отношения между сущностями ФИАС и системы
        $servicesList[EntityManager::class] = function (Application $app): EntityManager {
            return new BaseEntityManager(
                $app->get(EntityRegistry::class),
                $this->getOptionArrayStrings('entity_bindings')
            );
        };

        // объект для записи данных в БД
        $servicesList[Storage::class] = function (Application $app): Storage {
            return new CompositeStorage(
                $app->tagged($this->prefixString('storage'))
            );
        };

        // объект для записи данных в Eloquent
        $eloquentName = $this->prefixString('storage.eloquent') . '#' . $this->prefixString('storage');
        $servicesList[$eloquentName] = function (Application $app): Storage {
            return new EloquentStorage(
                $this->getOptionInt('insert_batch_count'),
                $app->get(LoggerInterface::class)
            );
        };

        // объект, который хранит текущую версию ФИАС
        $servicesList[VersionManager::class] = function (): VersionManager {
            return new EloquentVersionManager(
                $this->getOptionString('version_manager_entity')
            );
        };

        // сервис, который разбивает обрабатываемые файлы между потоками
        $servicesList[FilesDispatcher::class] = function (Application $app): FilesDispatcher {
            return new EntityFileDispatcher(
                $app->get(EntityManager::class)
            );
        };

        // фильтр для файлов
        $servicesList[$this->prefixString('filter.files_filter')] = function (): Filter {
            return new RegexpFilter(
                $this->getOptionArrayStrings('files_filter')
            );
        };
    }

    /**
     * Регистрирует задачи бандла.
     *
     * @param array<string, \Closure|string> $servicesList
     */
    private function registerTasks(array &$servicesList): void
    {
        // задача для очистки базы
        $servicesList[$this->prefixString('task.cleanup')] = CleanupTask::class;

        // задача для подготовки каталога загрузки
        $servicesList[$this->prefixString('task.prepare.folder')] = function (): Task {
            return new PrepareFolderTask(
                $this->getOptionString('temp_dir')
            );
        };

        // задача для проверки статуса ФИАС
        $servicesList[$this->prefixString('task.status.check')] = CheckStatusTask::class;

        // задача для получения ссылки на полную версию
        $servicesList[$this->prefixString('task.inform.full')] = InformFullTask::class;

        // задача для получения ссылки на изменения
        $servicesList[$this->prefixString('task.inform.delta')] = InformDeltaTask::class;

        // задача для загрузки файлов
        $servicesList[$this->prefixString('task.download')] = DownloadTask::class;

        // задача для распаковки файлов
        $servicesList[$this->prefixString('task.unpack')] = UnpackTask::class;

        // задача для очистки хранилища
        $servicesList[$this->prefixString('task.data.truncate')] = TruncateTask::class;

        // задача для получения списка файлов для обработки
        $servicesList[$this->prefixString('task.data.select_files')] = function (Application $app): Task {
            return new SelectFilesToProceedTask(
                $app->get(EntityManager::class),
                $app->get($this->prefixString('filter.files_filter'))
            );
        };

        // задача для вставки данных в хранилище
        $servicesList[$this->prefixString('task.data.insert')] = function (Application $app): Task {
            return new DataInsertTask(
                $app->get(EntityManager::class),
                $app->get(XmlReader::class),
                $app->get(Storage::class),
                $app->get($this->prefixString('serializer.serializer'))
            );
        };

        // задача для удаления данных из хранилища
        $servicesList[$this->prefixString('task.data.delete')] = function (Application $app): Task {
            return new DataDeleteTask(
                $app->get(EntityManager::class),
                $app->get(XmlReader::class),
                $app->get(Storage::class),
                $app->get($this->prefixString('serializer.serializer'))
            );
        };

        // задача для обновления данных в хранилище
        $servicesList[$this->prefixString('task.data.upsert')] = function (Application $app): Task {
            return new DataUpsertTask(
                $app->get(EntityManager::class),
                $app->get(XmlReader::class),
                $app->get(Storage::class),
                $app->get($this->prefixString('serializer.serializer'))
            );
        };

        // задача для получения ссылки на новую версию ФИАС
        $servicesList[$this->prefixString('task.version.get')] = VersionGetTask::class;

        // задача для сохранения установленной версии
        $servicesList[$this->prefixString('task.version.set')] = VersionSetTask::class;

        // задача, которая запускает установку в параллельных процессах
        $servicesList[$this->prefixString('task.process_switcher_install')] = function (Application $app): Task {
            return new ProcessSwitchTask(
                $app->get(FilesDispatcher::class),
                $this->getOptionString('path_to_bin'),
                $this->getOptionString('command_name_install'),
                $this->getOptionInt('number_of_parallel')
            );
        };

        // задача, которая запускает обновление в параллельных процессах
        $servicesList[$this->prefixString('task.process_switcher_update')] = function (Application $app): Task {
            return new ProcessSwitchTask(
                $app->get(FilesDispatcher::class),
                $this->getOptionString('path_to_bin'),
                $this->getOptionString('command_name_update'),
                $this->getOptionInt('number_of_parallel')
            );
        };
    }

    /**
     * Регистрирует пайплайны бандла.
     *
     * @param array<string, \Closure|string> $servicesList
     */
    private function registerPipelines(array &$servicesList): void
    {
        // процесс для параллельной установки ФИАС в нескольких потоках
        $servicesList[$this->prefixString('pipe.install_parallel_running')] = function (Application $app): Pipe {
            return new ArrayPipe(
                [
                    $app->get($this->prefixString('task.data.insert')),
                    $app->get($this->prefixString('task.data.delete')),
                ],
                null,
                $app->get(LoggerInterface::class)
            );
        };

        // процесс установки полной версии ФИАС
        $servicesList[$this->prefixString('pipe.install')] = function (Application $app): Pipe {
            return new ArrayPipe(
                [
                    $app->get($this->prefixString('task.status.check')),
                    $app->get($this->prefixString('task.prepare.folder')),
                    $app->get($this->prefixString('task.inform.full')),
                    $app->get($this->prefixString('task.download')),
                    $app->get($this->prefixString('task.unpack')),
                    $app->get($this->prefixString('task.data.truncate')),
                    $app->get($this->prefixString('task.data.select_files')),
                    $app->get($this->prefixString('task.process_switcher_install')),
                    $app->get($this->prefixString('task.version.set')),
                ],
                $app->get($this->prefixString('task.cleanup')),
                $app->get(LoggerInterface::class)
            );
        };

        // процесс установки версии ФИАС из загруженных на диск файлов
        $servicesList[$this->prefixString('pipe.install_from_folder')] = function (Application $app): Pipe {
            return new ArrayPipe(
                [
                    $app->get($this->prefixString('task.data.truncate')),
                    $app->get($this->prefixString('task.data.select_files')),
                    $app->get($this->prefixString('task.process_switcher_install')),
                ],
                null,
                $app->get(LoggerInterface::class)
            );
        };

        // процесс для параллельного обновения ФИАС в нескольких потоках
        $servicesList[$this->prefixString('pipe.update_parallel_running')] = function (Application $app): Pipe {
            return new ArrayPipe(
                [
                    $app->get($this->prefixString('task.data.upsert')),
                    $app->get($this->prefixString('task.data.delete')),
                ],
                null,
                $app->get(LoggerInterface::class)
            );
        };

        // процесс обновления установленной версии ФИАС
        $servicesList[$this->prefixString('pipe.update')] = function (Application $app): Pipe {
            return new ArrayPipe(
                [
                    $app->get($this->prefixString('task.status.check')),
                    $app->get($this->prefixString('task.version.get')),
                    $app->get($this->prefixString('task.prepare.folder')),
                    $app->get($this->prefixString('task.inform.delta')),
                    $app->get($this->prefixString('task.download')),
                    $app->get($this->prefixString('task.unpack')),
                    $app->get($this->prefixString('task.data.select_files')),
                    $app->get($this->prefixString('task.process_switcher_update')),
                    $app->get($this->prefixString('task.version.set')),
                ],
                $app->get($this->prefixString('task.cleanup')),
                $app->get(LoggerInterface::class)
            );
        };

        // процесс обновления версии ФИАС из загруженных на диск файлов
        $servicesList[$this->prefixString('pipe.update_from_folder')] = function (Application $app): Pipe {
            return new ArrayPipe(
                [
                    $app->get($this->prefixString('task.data.select_files')),
                    $app->get($this->prefixString('task.process_switcher_update')),
                ],
                null,
                $app->get(LoggerInterface::class)
            );
        };
    }

    /**
     * Возвращает значение указанной опции в виде строки.
     */
    private function getOptionString(string $name): string
    {
        $option = $this->getOptionByName($name);

        return \is_string($option) ? $option : '';
    }

    /**
     * Возвращает значение указанной опции в виде целого числа.
     */
    private function getOptionInt(string $name): int
    {
        $option = $this->getOptionByName($name);

        return \is_int($option) ? $option : 0;
    }

    /**
     * Возвращает значение указанной опции в виде массива.
     */
    private function getOptionArray(string $name): array
    {
        $option = $this->getOptionByName($name);

        return \is_array($option) ? $option : [];
    }

    /**
     * Возвращает значение указанной опции в виде массива строк.
     *
     * @return array<string, string>
     */
    private function getOptionArrayStrings(string $name): array
    {
        $raw = $this->getOptionArray($name);
        $result = [];
        foreach ($raw as $key => $value) {
            $result[(string) $key] = (string) $value;
        }

        return $result;
    }

    /**
     * Возвращает значение указанной опции в виде bool.
     */
    private function getOptionBool(string $name): bool
    {
        return (bool) $this->getOptionByName($name);
    }

    /**
     * Возвращает значение опции по ее названию.
     */
    private function getOptionByName(string $name): mixed
    {
        return config($this->prefixString($name));
    }

    /**
     * Добавляет префикс модуля к строке.
     */
    private function prefixString(string $string): string
    {
        if (strpos($string, $this->bundlePrefix) !== 0) {
            $string = $this->bundlePrefix . '.' . ltrim($string, '.');
        }

        return $string;
    }
}
