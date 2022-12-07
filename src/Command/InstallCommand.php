<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Liquetsoft\Fias\Component\Exception\PipeException;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;

/**
 * Консольная команда для установки ФИАС с ноля.
 */
class InstallCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'liquetsoft:fias:install';

    /**
     * @var string
     */
    protected $description = 'Installs full version of FIAS from scratch.';

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
        $this->pipeline = $app->get('liquetsoft_fias.pipe.install');
    }

    /**
     * Запуск команды на исполнение.
     *
     * @throws PipeException
     */
    public function handle(): void
    {
        $this->info('Installing full version of FIAS.');
        $start = microtime(true);

        $state = new ArrayState();

        try {
            $this->pipeline->run($state);
        } catch (\Throwable $e) {
            $message = "Something went wrong during the installation. Please check the Laravel's log to get more information.";
            throw new FiasConsoleException($message, 0, $e);
        }

        $total = round(microtime(true) - $start, 4);
        $this->info("Full version of FIAS installed after {$total} s.");
    }
}
