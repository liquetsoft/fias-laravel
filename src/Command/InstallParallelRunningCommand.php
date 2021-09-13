<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Liquetsoft\Fias\Component\Exception\PipeException;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;
use Liquetsoft\Fias\Component\Pipeline\Task\Task;

/**
 * Консольная команда, которая является одним из параллельных процессов установки ФИАС.
 */
class InstallParallelRunningCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'liquetsoft:fias:install_parallel_running {files?}';

    /**
     * @var string
     */
    protected $description = 'Command for running parallel installation.';

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
        $this->pipeline = $app->get('liquetsoft_fias.pipe.install_parallel_running');
    }

    /**
     * Запуск команды на исполнение.
     *
     * @throws PipeException
     */
    public function handle(): void
    {
        $files = $this->argument('files');
        if (\is_array($files)) {
            $files = reset($files);
        }

        if (!empty($files)) {
            $files = json_decode((string) $files, true);
        } else {
            $stdIn = file_get_contents('php://stdin');
            if (!empty($stdIn)) {
                $files = json_decode($stdIn, true);
            }
        }

        $state = new ArrayState();
        $state->setAndLockParameter(Task::FILES_TO_PROCEED, $files);
        $this->pipeline->run($state);
    }
}
