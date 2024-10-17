<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\State;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Консольная команда, которая является одним из параллельных процессов установки ФИАС.
 */
final class InstallParallelRunningCommand extends Command
{
    protected $signature = 'liquetsoft:fias:install_parallel_running';

    protected $description = 'Command for running parallel installation.';

    private readonly Pipe $pipeline;

    private readonly SerializerInterface $serializer;

    /**
     * В конструкторе передаем ссылку на пайплайн установки.
     */
    public function __construct(Application $app)
    {
        parent::__construct();
        $this->pipeline = $app->get('liquetsoft_fias.pipe.install_parallel_running');
        $this->serializer = $app->get('liquetsoft_fias.serializer.serializer');
    }

    /**
     * Запуск команды на исполнение.
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
