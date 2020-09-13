<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Liquetsoft\Fias\Component\Downloader\Downloader;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformer;
use Liquetsoft\Fias\Component\Unpacker\Unpacker;

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
     * @var string
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

    public function __construct(
        Downloader $downloader,
        Unpacker $unpacker,
        FiasInformer $informer
    ) {
        parent::__construct();

        $this->downloader = $downloader;
        $this->unpacker = $unpacker;
        $this->informer = $informer;
    }

    /**
     * Запуск команды на исполнение.
     */
    public function handle(): void
    {
        $pathToDownload = $this->argument('pathToDownload');
        $pathToDownload = (string) (is_array($pathToDownload) ? reset($pathToDownload) : $pathToDownload);

        $version = $this->argument('version');
        $version = (string) (is_array($version) ? reset($version) : $version);

        $extract = (bool) $this->option('extract');
    }
}
