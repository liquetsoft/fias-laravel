<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;
use Liquetsoft\Fias\Component\Pipeline\State\StateParameter;

/**
 * Консольная команда для обновления ФИАС из указанного каталога, в котором находятся файлы.
 */
final class UpdateFromFolderCommand extends Command
{
    protected $signature = 'liquetsoft:fias:update_from_folder {folder : Path to folder with extracted FIAS files}';

    protected $description = 'Updates FIAS version from downloaded files saved in folder.';

    private readonly Pipe $pipeline;

    public function __construct(Application $app)
    {
        parent::__construct();
        $this->pipeline = $app->get('liquetsoft_fias.pipe.update_from_folder');
    }

    /**
     * Запуск команды на исполнение.
     */
    public function handle(): void
    {
        $folder = $this->argument('folder');
        $folder = realpath(\is_array($folder) ? (string) reset($folder) : (string) $folder);
        if (!is_dir($folder)) {
            throw new \InvalidArgumentException("Can't find '{$folder}' folder to read FIAS files");
        }

        $this->info("Updating FIAS version from '{$folder}' folder");
        $start = microtime(true);

        $state = new ArrayState();
        $state->setAndLockParameter(StateParameter::PATH_TO_EXTRACT_FOLDER, $folder);

        try {
            $this->pipeline->run($state);
        } catch (\Throwable $e) {
            throw new FiasConsoleException(
                message: "Something went wrong during the updating from folder. Please check the Laravel's log to get more information",
                previous: $e
            );
        }

        $total = round(microtime(true) - $start, 4);
        $this->info("FIAS updated after {$total} s");
    }
}
