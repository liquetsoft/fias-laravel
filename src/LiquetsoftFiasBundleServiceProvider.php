<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Liquetsoft\Fias\Component\Downloader\CurlDownloader;
use Liquetsoft\Fias\Component\Downloader\Downloader;
use Liquetsoft\Fias\Component\EntityManager\BaseEntityManager;
use Liquetsoft\Fias\Component\EntityManager\EntityManager;
use Liquetsoft\Fias\Component\EntityRegistry\EntityRegistry;
use Liquetsoft\Fias\Component\EntityRegistry\YamlEntityRegistry;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformer;
use Liquetsoft\Fias\Component\FiasInformer\SoapFiasInformer;
use Liquetsoft\Fias\Component\Pipeline\Pipe\ArrayPipe;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\Task\CleanupTask;
use Liquetsoft\Fias\Component\Pipeline\Task\DataDeleteTask;
use Liquetsoft\Fias\Component\Pipeline\Task\DataInsertTask;
use Liquetsoft\Fias\Component\Pipeline\Task\DataUpsertTask;
use Liquetsoft\Fias\Component\Pipeline\Task\DownloadTask;
use Liquetsoft\Fias\Component\Pipeline\Task\InformDeltaTask;
use Liquetsoft\Fias\Component\Pipeline\Task\InformFullTask;
use Liquetsoft\Fias\Component\Pipeline\Task\PrepareFolderTask;
use Liquetsoft\Fias\Component\Pipeline\Task\Task;
use Liquetsoft\Fias\Component\Pipeline\Task\TruncateTask;
use Liquetsoft\Fias\Component\Pipeline\Task\UnpackTask;
use Liquetsoft\Fias\Component\Pipeline\Task\VersionGetTask;
use Liquetsoft\Fias\Component\Pipeline\Task\VersionSetTask;
use Liquetsoft\Fias\Component\Storage\Storage;
use Liquetsoft\Fias\Component\Unpacker\RarUnpacker;
use Liquetsoft\Fias\Component\Unpacker\Unpacker;
use Liquetsoft\Fias\Component\VersionManager\VersionManager;
use Liquetsoft\Fias\Component\XmlReader\BaseXmlReader;
use Liquetsoft\Fias\Component\XmlReader\XmlReader;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\InstallCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\TruncateCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command\UpdateCommand;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\VersionManager\EloquentVersionManager;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Storage\EloquentStorage;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\FiasSerializer;
use SoapClient;
use Closure;

/**
 * Service provider для модуля.
 */
class LiquetsoftFiasBundleServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $bundlePrefix = 'liquetsoft_fias';

    /**
     * Регистрирует сервисы модуля в приложении.
     *
     * @return void
     */
    public function register(): void
    {
        $descriptions = $this->getServicesDescriptions();
        foreach ($descriptions as $key => $description) {
            $this->app->singleton($key, $description);
        }

        $this->mergeConfigFrom(
            __DIR__ . "/Config/{$this->prefixString('php')}", $this->bundlePrefix
        );
    }

    /**
     * Загружает данныем модуля в приложение.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migration');

        $this->publishes([
            __DIR__ . "/Config/{$this->prefixString('php')}" => config_path($this->prefixString('php')),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                UpdateCommand::class,
                TruncateCommand::class,
            ]);
        }
    }

    /**
     * Возвращает массив сервисов с их определениями.
     *
     * @return array<string, Closure|string>
     */
    protected function getServicesDescriptions(): array
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
     * @param array $servicesList
     *
     * @return void
     */
    protected function registerServices(array &$servicesList): void
    {
        // soap-клиент для получения сссылки на массив с файлами
        $servicesList[$this->prefixString('informer.soap')] = function (): SoapClient {
            return new SoapClient(
                $this->getOptionString('informer_wsdl'),
                ['exceptions' => true]
            );
        };

        // объект, который получает ссылку на ФИАС через soap-клиент
        $servicesList[FiasInformer::class] = function (Application $app): FiasInformer {
            return new SoapFiasInformer(
                $app->get(
                    $this->prefixString('informer.soap')
                )
            );
        };

        // объект, который загружает файлы
        $servicesList[Downloader::class] = CurlDownloader::class;

        // объект, который распаковывает архивы
        $servicesList[Unpacker::class] = RarUnpacker::class;

        // объект, который читает xml из файла
        $servicesList[XmlReader::class] = BaseXmlReader::class;

        // сериалайзер, который преобразует xml для единичной записи в объект
        $servicesList[$this->prefixString('serializer.serializer')] = FiasSerializer::class;

        // объект с описаниями сущностей ФИАС
        $servicesList[EntityRegistry::class] = function (): EntityRegistry {
            return new YamlEntityRegistry(
                $this->getOptionString('registry_yaml')
            );
        };

        // объект, который определяет отношения между сущностями ФИАС и системы
        $servicesList[EntityManager::class] = function (Application $app): EntityManager {
            return new BaseEntityManager(
                $app->get(EntityRegistry::class),
                $this->getOptionArray('entity_bindings')
            );
        };

        // объект для записи данных в БД
        $servicesList[Storage::class] = function (): Storage {
            return new EloquentStorage($this->getOptionInt('insert_batch_count'));
        };

        // объект, который хранит текущую версию ФИАС
        $servicesList[VersionManager::class] = function (): VersionManager {
            return new EloquentVersionManager(
                $this->getOptionString('version_manager_entity')
            );
        };
    }

    /**
     * Регистрирует задачи бандла.
     *
     * @param array $servicesList
     *
     * @return void
     */
    protected function registerTasks(array &$servicesList): void
    {
        // задача для очистки базы
        $servicesList[$this->prefixString('task.cleanup')] = CleanupTask::class;

        // задача для подготовки каталога загрузки
        $servicesList[$this->prefixString('task.prepare.folder')] = function (): Task {
            return new PrepareFolderTask(
                $this->getOptionString('temp_dir')
            );
        };

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

        // задача для обновления данных в хрпнилище
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
    }

    /**
     * Регистрирует пайплайны бандла.
     *
     * @param array $servicesList
     *
     * @return void
     */
    protected function registerPipelines(array &$servicesList): void
    {
        // процесс установки полной версии ФИАС
        $servicesList[$this->prefixString('pipe.install')] = function (Application $app): Pipe {
            return new ArrayPipe(
                [
                    $app->get($this->prefixString('task.prepare.folder')),
                    $app->get($this->prefixString('task.inform.full')),
                    $app->get($this->prefixString('task.download')),
                    $app->get($this->prefixString('task.unpack')),
                    $app->get($this->prefixString('task.data.truncate')),
                    $app->get($this->prefixString('task.data.insert')),
                    $app->get($this->prefixString('task.data.delete')),
                    $app->get($this->prefixString('task.version.set')),
                ],
                $app->get($this->prefixString('task.cleanup'))
            );
        };

        // процесс установки версии ФИАС из загруженных на диск файлов
        $servicesList[$this->prefixString('pipe.install_from_folder')] = function (Application $app): Pipe {
            return new ArrayPipe(
                [
                    $app->get($this->prefixString('task.data.truncate')),
                    $app->get($this->prefixString('task.data.insert')),
                    $app->get($this->prefixString('task.data.delete')),
                ]
            );
        };

        // процесс обновления установленной версии ФИАС
        $servicesList[$this->prefixString('pipe.update')] = function (Application $app): Pipe {
            return new ArrayPipe(
                [
                    $app->get($this->prefixString('task.version.get')),
                    $app->get($this->prefixString('task.prepare.folder')),
                    $app->get($this->prefixString('task.inform.delta')),
                    $app->get($this->prefixString('task.download')),
                    $app->get($this->prefixString('task.unpack')),
                    $app->get($this->prefixString('task.data.upsert')),
                    $app->get($this->prefixString('task.data.delete')),
                    $app->get($this->prefixString('task.version.set')),
                ],
                $app->get($this->prefixString('task.cleanup'))
            );
        };
    }

    /**
     * Возвращает значение указанной опции в виде строки.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getOptionString(string $name): string
    {
        $option = config($this->prefixString($name));

        return is_string($option) ? $option : '';
    }

    /**
     * Возвращает значение указанной опции в виде целого числа.
     *
     * @param string $name
     *
     * @return int
     */
    protected function getOptionInt(string $name): int
    {
        $option = config($this->prefixString($name));

        return is_int($option) ? $option : 0;
    }

    /**
     * Возвращает значение указанной опции в виде массива.
     *
     * @param string $name
     *
     * @return array
     */
    protected function getOptionArray(string $name): array
    {
        $option = config($this->prefixString($name));

        return is_array($option) ? $option : [];
    }

    /**
     * Добавляет префикс модуля к строке.
     *
     * @param string $string
     *
     * @return string
     */
    protected function prefixString(string $string): string
    {
        if (strpos($string, $this->bundlePrefix) !== 0) {
            $string = $this->bundlePrefix . '.' . ltrim($string, '.');
        }

        return $string;
    }
}
