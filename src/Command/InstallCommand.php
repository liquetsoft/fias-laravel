<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Liquetsoft\Fias\Component\Exception\PipeException;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;

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
     */
    public function __construct()
    {
        parent::__construct();
        $this->pipeline = $this->getLaravel()->get('liquetsoft_fias.pipe.install');
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

        $state = new ArrayState;
        $this->pipeline->run($state);

        $total = round(microtime(true) - $start, 4);
        $this->info("Full version of FIAS installed after {$total} s.");
    }
}
