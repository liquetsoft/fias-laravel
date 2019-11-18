<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use InvalidArgumentException;
use Liquetsoft\Fias\Component\Exception\PipeException;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;
use Liquetsoft\Fias\Component\Pipeline\Task\Task;
use SplFileInfo;

/**
 * Консольная команда для установки ФИАС с ноля из указанного каталога, в котором находятся файлы.
 */
class InstallFromFolder extends Command
{
    /**
     * @var string
     */
    protected $signature = 'liquetsoft:fias:install_from_folder {folder : Path to folder with extracted FIAS files}';

    /**
     * @var string
     */
    protected $description = 'Installs full version of FIAS from downloaded file saved in folder.';

    /**
     * @var Pipe
     */
    protected $pipeline;

    /**
     * В конструкторе передаем ссылку на пайплайн установки.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct();
        $this->pipeline = $app->get('liquetsoft_fias.pipe.install_from_folder');
    }

    /**
     * Запуск команды на исполнение.
     *
     * @throws PipeException
     * @throws InvalidArgumentException
     */
    public function handle(): void
    {
        $folder = $this->argument('folder');
        $folder = realpath(is_array($folder) ? (string) reset($folder) : (string) $folder);
        if (!is_dir($folder)) {
            throw new InvalidArgumentException("Can't find '{$folder}' folder to read FIAS files.");
        }

        $this->info("Installing full version of FIAS from '{$folder}' folder.");
        $start = microtime(true);

        $state = new ArrayState;
        $state->setAndLockParameter(Task::EXTRACT_TO_FOLDER_PARAM, new SplFileInfo($folder));

        $this->pipeline->run($state);

        $total = round(microtime(true) - $start, 4);
        $this->info("Full version of FIAS installed after {$total} s.");
    }
}
