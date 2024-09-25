<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;
use Liquetsoft\Fias\Component\Pipeline\State\StateParameter;

/**
 * Консольная команда для обновления ФИАС с текущей версии до самой новой.
 */
final class UpdateCommand extends Command
{
    protected $signature = 'liquetsoft:fias:update';

    protected $description = 'Updates FIAS to latest version.';

    private readonly Pipe $pipeline;

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
     */
    public function handle(): void
    {
        $this->info('Updating FIAS');
        $start = microtime(true);

        do {
            $state = new ArrayState();
            try {
                $this->pipeline->run($state);
            } catch (\Throwable $e) {
                throw new FiasConsoleException(
                    message: "Something went wrong during the updating. Please check the Laravel's log to get more information",
                    previous: $e
                );
            }
            $newVersion = $state->getParameterString(StateParameter::FIAS_NEXT_VERSION_NUMBER);
            if ($newVersion !== '') {
                $this->info("Updated to version '{$newVersion}'");
            }
        } while ($newVersion !== '');

        $total = round(microtime(true) - $start, 4);
        $this->info("FIAS updated after {$total} s");
    }
}
