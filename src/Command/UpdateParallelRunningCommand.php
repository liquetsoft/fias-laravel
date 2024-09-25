<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Liquetsoft\Fias\Component\Exception\PipeException;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;
use Liquetsoft\Fias\Component\Pipeline\State\StateParameter;

/**
 * Консольная команда, которая является одним из параллельных процессов обновления ФИАС.
 */
final class UpdateParallelRunningCommand extends Command
{
    protected $signature = 'liquetsoft:fias:update_parallel_running {files?}';

    protected $description = 'Command for running parallel update.';

    private readonly Pipe $pipeline;

    /**
     * В конструкторе передаем ссылку на пайплайн установки.
     */
    public function __construct(Application $app)
    {
        parent::__construct();
        $this->pipeline = $app->get('liquetsoft_fias.pipe.update_parallel_running');
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

        if ($files !== false && $files !== null && $files !== '') {
            $files = json_decode((string) $files, true);
        } else {
            $stdIn = file_get_contents('php://stdin');
            if ($stdIn !== false && $stdIn !== '') {
                $files = json_decode($stdIn, true);
            }
        }

        $state = new ArrayState();
        $state->setAndLockParameter(StateParameter::FILES_TO_PROCEED, $files);
        $this->pipeline->run($state);
    }
}
