<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Liquetsoft\Fias\Component\Exception\PipeException;
use Liquetsoft\Fias\Component\FiasInformer\InformerResponse;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;
use Liquetsoft\Fias\Component\Pipeline\State\StateParameter;

/**
 * Консольная команда для обновления ФИАС с текущей версии до самой новой.
 */
class UpdateCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'liquetsoft:fias:update';

    /**
     * @var string|null
     */
    protected $description = 'Updates FIAS to latest version.';

    /**
     * @var Pipe
     */
    protected $pipeline;

    /**
     * В конструкторе передаем ссылку на пайплайн установки.
     */
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
            try {
                $this->pipeline->run($state);
            } catch (\Throwable $e) {
                $message = "Something went wrong during the updating. Please check the Laravel's log to get more information.";
                throw new FiasConsoleException($message, 0, $e);
            }
            $info = $state->getParameter(StateParameter::FIAS_INFO);
            if (!($info instanceof InformerResponse)) {
                throw new \RuntimeException(
                    "There is no '" . StateParameter::FIAS_INFO . "' parameter in state."
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
