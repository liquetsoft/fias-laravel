<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformer;
use Liquetsoft\Fias\Component\FiasInformer\InformerResponse;
use Liquetsoft\Fias\Component\VersionManager\VersionManager;

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
     * @var string|null
     */
    protected $description = 'Shows information about current version, delta versions and full version.';

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
        $currentVersion = $this->versionManager->getCurrentVersion();
        if ($currentVersion->hasResult()) {
            $this->showTable('Current version of FIAS', [$currentVersion]);
        } else {
            $this->showEmptyResponse('Current version of FIAS', 'FIAS is not installed');
        }

        $completeVersion = $this->informer->getCompleteInfo();
        if ($completeVersion->hasResult()) {
            $this->showTable('Complete version of FIAS', [$completeVersion]);
        } else {
            $this->showEmptyResponse('Complete version of FIAS', 'Complete version not found');
        }

        $deltaVersions = $this->informer->getDeltaList();
        $this->showTable('Delta versions of FIAS', array_slice($deltaVersions, 0, 15));

        $this->line('');
    }

    /**
     * Отображает список версий в виде таблицы.
     *
     * @param string             $header
     * @param InformerResponse[] $versions
     */
    private function showTable(string $header, array $versions): void
    {
        $rows = [];
        foreach ($versions as $version) {
            $rows[] = [
                'Version' => $version->getVersion(),
                'Url' => $version->getUrl(),
            ];
        }

        $this->line('');
        $this->info($header);
        $this->table(['Version', 'Url'], $rows);
    }

    /**
     * Отображает пустую таблицу.
     *
     * @param string $header
     * @param string $message
     */
    private function showEmptyResponse(string $header, string $message = 'No data provided'): void
    {
        $this->line('');
        $this->info($header);
        $this->line('');
        $this->error($message);
    }
}
