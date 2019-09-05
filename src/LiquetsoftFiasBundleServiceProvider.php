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
use Liquetsoft\Fias\Component\Serializer\FiasSerializer;
use Liquetsoft\Fias\Component\Unpacker\RarUnpacker;
use Liquetsoft\Fias\Component\Unpacker\Unpacker;
use Liquetsoft\Fias\Component\XmlReader\BaseXmlReader;
use Liquetsoft\Fias\Component\XmlReader\XmlReader;
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
    }

    /**
     * Загружает данныем модуля в приложение.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migration');
    }

    /**
     * Возвращает массив сервисов с их определениями.
     *
     * @return array<string, Closure|string>
     */
    protected function getServicesDescriptions(): array
    {
        $servicesList = [];

        // soap-клиент для получения сссылки на массив с файлами
        $servicesList[$this->prefixString('informer.soap')] = function () {
            return new SoapClient(
                $this->getOptionString('informer_wsdl'),
                ['exceptions' => true]
            );
        };

        // объект, который получает ссылку на ФИАС через soap-клиент
        $servicesList[FiasInformer::class] = function (Application $app) {
            new SoapFiasInformer(
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
        $servicesList[EntityRegistry::class] = function () {
            return new YamlEntityRegistry(
                $this->getOptionString('registry_yaml')
            );
        };

        // объект, который определяет отношения между сущностями ФИАС и системы
        $servicesList[EntityManager::class] = function (Application $app) {
            return new BaseEntityManager(
                $app->get(EntityRegistry::class),
                $this->getOptionArray('entity_bindings')
            );
        };

        return $servicesList;
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
