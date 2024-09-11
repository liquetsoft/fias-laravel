<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Liquetsoft\Fias\Component\Downloader\Downloader;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformer;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformerResponse;
use Liquetsoft\Fias\Component\Unpacker\Unpacker;
use Marvin255\FileSystemHelper\FileSystemHelperInterface;

/**
 * Консольная команда, которая загружает указанную версию ФИАС в указанную папку.
 */
final class DownloadCommand extends Command
{
    private const LATEST_VERSION_NAME = 'latest';

    protected $signature = 'liquetsoft:fias:download {pathToDownload} {version=' . self::LATEST_VERSION_NAME . '} {--X|extract} {--D|delta}';

    protected $description = 'Downloads set version of FIAS.';

    public function __construct(
        private readonly Downloader $downloader,
        private readonly Unpacker $unpacker,
        private readonly FiasInformer $informer,
        private readonly FileSystemHelperInterface $fs,
    ) {
        parent::__construct();
    }

    /**
     * Запуск команды на исполнение.
     */
    public function handle(): void
    {
        $version = $this->getVersion();
        $pathToDownload = $this->getPathToDownload();
        $needExtraction = (bool) $this->option('extract');
        $needDelta = (bool) $this->option('delta');

        $fiasVersion = $this->findVersion($version);
        $url = $needDelta ? $fiasVersion->getDeltaUrl() : $fiasVersion->getFullUrl();

        $this->info("Downloading '{$url}' to '{$pathToDownload->getPathname()}'");
        $this->downloader->download($url, $pathToDownload);

        if ($needExtraction) {
            $this->extract($pathToDownload);
        }
    }

    /**
     * Забирает значение агрумента с версией для загрузки.
     */
    private function getVersion(): string
    {
        $version = $this->argument('version');
        $version = (string) (\is_array($version) ? reset($version) : $version);

        return $version;
    }

    /**
     * Возвращает объект с путем для загрузки файла в локальную файловую систему.
     */
    private function getPathToDownload(): \SplFileInfo
    {
        $version = $this->getVersion();
        $target = $this->argument('pathToDownload');
        $target = (string) (\is_array($target) ? reset($target) : $target);
        $target = rtrim($target, '/\\') . \DIRECTORY_SEPARATOR . 'fias_' . $version . '.zip';

        return new \SplFileInfo($target);
    }

    /**
     * Получает url для указанной версии.
     */
    private function findVersion(string $version): FiasInformerResponse
    {
        $fiasVersion = null;

        if ($version === self::LATEST_VERSION_NAME) {
            $fiasVersion = $this->informer->getLatestVersion();
        } else {
            $allVersions = $this->informer->getAllVersions();
            $version = (int) $version;
            foreach ($allVersions as $deltaVervion) {
                if ($deltaVervion->getVersion() === $version) {
                    $fiasVersion = $deltaVervion;
                    break;
                }
            }
        }

        if ($fiasVersion === null) {
            throw new \RuntimeException("Can't find FIAS response for '{$version}' version");
        }

        return $fiasVersion;
    }

    /**
     * Распаковывает загруженный архив.
     */
    private function extract(\SplFileInfo $archive): void
    {
        $extractTo = $archive->getPath() . \DIRECTORY_SEPARATOR . $archive->getBasename('.zip');
        $extractTo = new \SplFileInfo($extractTo);

        $this->fs->mkdirIfNotExist($extractTo);
        $this->fs->emptyDir($extractTo);

        $this->info("Extracting '{$archive->getPathname()}' to '{$extractTo->getPathname()}'.");
        $this->unpacker->unpack($archive, $extractTo);

        $this->info("Removing '{$archive->getPathname()}' after extraction.");
        $this->fs->remove($archive);
    }
}
