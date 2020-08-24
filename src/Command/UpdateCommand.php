<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Liquetsoft\Fias\Component\Exception\PipeException;
use Liquetsoft\Fias\Component\FiasInformer\InformerResponse;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;
use Liquetsoft\Fias\Component\Pipeline\Task\Task;
use RuntimeException;

/**
 * Консольная команда для обновления ФИАС с текущей версии до самой новой.
 */
class UpdateCommand extends Command
{
    protected $signature = 'liquetsoft:fias:update';

    protected $description = 'Updates FIAS to latest version.';

    protected Pipe $pipeline;

    public function __construct(Application $app)
    {
        parent::__construct();
        $this->pipeline = $app->get('liquetsoft_fias.pipe.update');
    }

    /**
     * Запуск команды на исполнение.
     *
     * @throws PipeException
     */
    public function handle(): void
    {
        $this->info('Updating FIAS.');
        $start = microtime(true);

        do {
            $state = new ArrayState();
            $this->pipeline->run($state);
            $info = $state->getParameter(Task::FIAS_INFO_PARAM);
            if (!($info instanceof InformerResponse)) {
                throw new RuntimeException(
                    "There is no '" . Task::FIAS_INFO_PARAM . "' parameter in state."
                );
            }
            if ($info->hasResult()) {
                $this->info("Updated to version '{$info->getVersion()}'.");
            }
        } while ($info->hasResult());

        $total = round(microtime(true) - $start, 4);
        $this->info("FIAS updated after {$total} s.");
    }
}
