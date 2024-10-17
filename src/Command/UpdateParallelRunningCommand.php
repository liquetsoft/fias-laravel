<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Liquetsoft\Fias\Component\Exception\PipeException;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\State;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Консольная команда, которая является одним из параллельных процессов обновления ФИАС.
 */
final class UpdateParallelRunningCommand extends Command
{
    protected $signature = 'liquetsoft:fias:update_parallel_running';

    protected $description = 'Command for running parallel update.';

    private readonly Pipe $pipeline;

    /**
     * В конструкторе передаем ссылку на пайплайн установки.
     */
    public function __construct(
        private readonly SerializerInterface $serializer,
        Application $app,
    ) {
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
        $stdIn = file_get_contents('php://stdin');
        if ($stdIn === false || $stdIn === '') {
            return;
        }

        $state = $this->serializer->deserialize($stdIn, State::class, 'json');

        $this->pipeline->run($state);
    }
}
