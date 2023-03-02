<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Liquetsoft\Fias\Component\Downloader\Downloader;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformer;
use Liquetsoft\Fias\Component\Unpacker\Unpacker;
use Marvin255\FileSystemHelper\FileSystemFactory;
use Marvin255\FileSystemHelper\FileSystemHelperInterface;

/**
 * Консольная команда, которая загружает указанную версию ФИАС в указанную папку.
 */
class DownloadCommand extends Command
{
    private const FULL_VERSION_NAME = 'full';

    /**
     * @var string
     */
    protected $signature = 'liquetsoft:fias:download {pathToDownload} {version=' . self::FULL_VERSION_NAME . '} {--X|extract}';

    /**
     * @var string|null
     */
    protected $description = 'Downloads set version of FIAS.';

    /**
     * @var Downloader
     */
    private $downloader;

    /**
     * @var Unpacker
     */
    private $unpacker;

    /**
     * @var FiasInformer
     */
    private $informer;

    /**
     * @var FileSystemHelperInterface
     */
    private $fs;

    public function __construct(
        Downloader $downloader,
        Unpacker $unpacker,
        FiasInformer $informer
    ) {
        parent::__construct();

        $this->downloader = $downloader;
        $this->unpacker = $unpacker;
        $this->informer = $informer;
        $this->fs = FileSystemFactory::create();
    }

    /**
     * Запуск команды на исполнение.
     */
    public function handle(): void
    {
        $version = $this->getVersion();
        $pathToDownload = $this->getPathToDownload();
        $needExtraction = (bool) $this->option('extract');

        $url = $this->findUrlForVersion($version);

        $this->info("Downloading '{$url}' to '{$pathToDownload->getPathname()}'.");
        $this->downloader->download($url, $pathToDownload);

        if ($needExtraction) {
            $this->extract($pathToDownload);
        }
    }

    /**
     * Забирает значение агрумента с версией для загрузки.
     *
     * @return string
     */
    private function getVersion(): string
    {
        $version = $this->argument('version');
        $version = (string) (\is_array($version) ? reset($version) : $version);

        return $version;
    }

    /**
     * Возвращает объект с путем для загрузки файла в локальную файловую систему.
     *
     * @return \SplFileInfo
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
     *
     * @param string $version
     *
     * @return string
     */
    private function findUrlForVersion(string $version): string
    {
        $url = '';

        if ($version === self::FULL_VERSION_NAME) {
            $url = $this->informer->getCompleteInfo()->getUrl();
        } else {
            $allVersions = $this->informer->getDeltaList();
            $version = (int) $version;
            foreach ($allVersions as $deltaVervion) {
                if ($deltaVervion->getVersion() === $version) {
                    $url = $deltaVervion->getUrl();
                    break;
                }
            }
        }

        if (empty($url)) {
            $message = sprintf("Can't find url for '%s' version.", $version);
            throw new \RuntimeException($message);
        }

        return $url;
    }

    /**
     * Распаковывает загруженный архив.
     *
     * @param \SplFileInfo $archive
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
