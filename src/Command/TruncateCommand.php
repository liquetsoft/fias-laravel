<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;
use Liquetsoft\Fias\Component\Pipeline\Task\Task;

/**
 * Команда, которая очищает хранилища для всех сущностей проекта, привязанных
 * к сущностям ФИАС.
 */
final class TruncateCommand extends Command
{
    protected $signature = 'liquetsoft:fias:truncate';

    protected $description = 'Truncates storage for binded entities.';

    private readonly Task $task;

    /**
     * В конструкторе передаем ссылку на пайплайн установки.
     */
    public function __construct(Application $app)
    {
        parent::__construct();
        $this->task = $app->get('liquetsoft_fias.task.data.truncate');
    }

    /**
     * Запуск команды на исполнение.
     */
    public function handle(): void
    {
        $this->info('Truncating storage for binded entities');

        $this->task->run(new ArrayState());

        $this->info('Storage truncated');
    }
}
