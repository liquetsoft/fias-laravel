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
    protected $signature = 'liquetsoft:fias:install_parallel_running {files_to_insert} {files_to_delete}';

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
        $filesToInsert = $this->argument('files_to_insert');
        if (\is_array($filesToInsert)) {
            $filesToInsert = reset($filesToInsert);
        }
        $filesToInsert = json_decode((string) $filesToInsert, true);

        $filesToDelete = $this->argument('files_to_delete');
        if (\is_array($filesToDelete)) {
            $filesToDelete = reset($filesToDelete);
        }
        $filesToDelete = json_decode((string) $filesToDelete, true);

        $state = new ArrayState();
        $state->setAndLockParameter(Task::FILES_TO_INSERT_PARAM, $filesToInsert);
        $state->setAndLockParameter(Task::FILES_TO_DELETE_PARAM, $filesToDelete);
        $this->pipeline->run($state);
    }
}
