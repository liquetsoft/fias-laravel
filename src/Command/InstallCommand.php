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
    protected $signature = 'liquetsoft:fias:install';

    protected $description = 'Installs full version of FIAS from scratch.';

    protected Pipe $pipeline;

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
        $this->pipeline->run($state);

        $total = round(microtime(true) - $start, 4);
        $this->info("Full version of FIAS installed after {$total} s.");
    }
}
