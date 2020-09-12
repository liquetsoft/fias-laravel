<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Liquetsoft\Fias\Component\Exception\PipeException;
use Liquetsoft\Fias\Component\FiasInformer\InformerResponse;
use Liquetsoft\Fias\Component\Pipeline\Pipe\Pipe;
use Liquetsoft\Fias\Component\Pipeline\State\ArrayState;
use Liquetsoft\Fias\Component\Pipeline\Task\Task;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformer;
use Liquetsoft\Fias\Component\VersionManager\VersionManager;
use Liquetsoft\Fias\Component\FiasInformer\InformerResponse;
use RuntimeException;

/**
 * Консольная команда, которая отображает текущую версию, полную версию
 * и список версий на обновление.
 */
class VersionsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'liquetsoft:fias:versions';

    /**
     * @var string
     */
    protected $description = 'Show information about current version, delta versions and full version.';

    /**
     * @var FiasInformer
     */
    private $informer;

    /**
     * @var VersionManager
     */
    private $versionManager;

    public function __construct(FiasInformer $informer, VersionManager $versionManager)
    {
        parent::__construct();

        $this->informer = $informer;
        $this->versionManager = $versionManager;
    }

    /**
     * Запуск команды на исполнение.
     */
    public function handle(): void
    {

    }

    /**
     * Отображает список версий в виде таблицы.
     *
     * @param string $header
     * @param InformerResponse[] $headers
     */
    private function showTable(string $header, array $versions): void
    {

    }
}
