<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;

/**
 * Консольная команда для установки ФИАС с ноля.
 */
final class InstallCommand extends Command
{
    protected $signature = 'liquetsoft:fias:install';

    protected $description = 'Installs full version of FIAS from scratch.';

    private readonly Pipe $pipeline;

    /**
     * В конструкторе передаем ссылку на пайплайн установки.
     */
    public function __construct(Application $app)
    {
        parent::__construct();
        $this->pipeline = $app->get('liquetsoft_fias.pipe.install');
    }

    /**
     * Запуск команды на исполнение.
     */
    public function handle(): void
    {
        $this->info('Installing full version of FIAS');
        $start = microtime(true);

        try {
            $this->pipeline->run(new ArrayState());
        } catch (\Throwable $e) {
            throw new FiasConsoleException(
                message: "Something went wrong during the installation. Please check the Laravel's log to get more information",
                previous: $e
            );
        }

        $total = round(microtime(true) - $start, 4);
        $this->info("Full version of FIAS installed after {$total} s");
    }
}
