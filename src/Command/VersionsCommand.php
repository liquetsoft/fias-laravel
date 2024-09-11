<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformer;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformerResponse;
use Liquetsoft\Fias\Component\VersionManager\VersionManager;

/**
 * Консольная команда, которая отображает текущую версию, полную версию
 * и список версий на обновление.
 */
final class VersionsCommand extends Command
{
    protected $signature = 'liquetsoft:fias:versions';

    protected $description = 'Shows information about current version, delta versions and full version.';

    public function __construct(
        private readonly FiasInformer $informer,
        private readonly VersionManager $versionManager,
    ) {
        parent::__construct();
    }

    /**
     * Запуск команды на исполнение.
     */
    public function handle(): void
    {
        $currentVersion = $this->versionManager->getCurrentVersion();
        if ($currentVersion !== null) {
            $this->showTable(
                'Current version of FIAS',
                [
                    $currentVersion,
                ]
            );
        } else {
            $this->showEmptyResponse('Current version of FIAS', 'FIAS is not installed');
        }

        $latest = $this->informer->getLatestVersion();
        if ($latest !== null) {
            $this->showTable(
                'Latest version of FIAS',
                [
                    $latest,
                ]
            );
        } else {
            $this->showEmptyResponse('Latest version of FIAS', 'Latest version not found');
        }

        $deltaVersions = $this->informer->getAllVersions();
        $this->showTable(
            'All versions of FIAS',
            \array_slice($deltaVersions, 0, 15)
        );

        $this->line('');
    }

    /**
     * Отображает список версий в виде таблицы.
     *
     * @param FiasInformerResponse[] $versions
     */
    private function showTable(string $header, array $versions): void
    {
        $rows = [];
        foreach ($versions as $version) {
            $rows[] = [
                'Version' => $version->getVersion(),
                'Full url' => $version->getFullUrl(),
                'Delta url' => $version->getDeltaUrl(),
            ];
        }

        $this->line('');
        $this->info($header);
        $this->table(
            [
                'Version',
                'Full url',
                'Delta url',
            ],
            $rows
        );
    }

    /**
     * Отображает пустую таблицу.
     */
    private function showEmptyResponse(string $header, string $message = 'No data provided'): void
    {
        $this->line('');
        $this->info($header);
        $this->line('');
        $this->error($message);
    }
}
