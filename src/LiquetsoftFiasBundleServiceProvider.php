<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle;

use Illuminate\Contracts\Support\DeferrableProvider;
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
class LiquetsoftFiasBundleServiceProvider extends ServiceProvider implements DeferrableProvider
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
        $descriptions = $this->getServicesDescription();

        foreach ($descriptions as $key => $description) {
            $this->app->singleton($key, $description);
        }
    }

    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        $descriptions = $this->getServicesDescription();

        return array_keys($descriptions);
    }

    /**
     * Возвращает массив сервисов с их определениями.
     *
     * @return array<string, Closure|string>
     */
    protected function getServicesDescription(): array
    {
        return [
            $this->prefixString('informer.soap') => function (Application $app) {
                return new SoapClient($this->getOptionString('informer_wsdl'), ['exceptions' => true]);
            },
            FiasInformer::class => function (Application $app) {
                new SoapFiasInformer($app->get($this->prefixString('informer.soap')));
            },
            Downloader::class => CurlDownloader::class,
            Unpacker::class => RarUnpacker::class,
            XmlReader::class => BaseXmlReader::class,
            $this->prefixString('serializer.serializer') => FiasSerializer::class,
            EntityRegistry::class => function (Application $app) {
                return new YamlEntityRegistry($this->getOptionString('registry_yaml'));
            },
            EntityManager::class => function (Application $app) {
                return new BaseEntityManager(
                    $app->get(EntityRegistry::class),
                    $this->getOptionArray('entity_bindings')
                );
            },
        ];
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
