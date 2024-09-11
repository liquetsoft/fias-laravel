<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Liquetsoft\Fias\Component\FiasStatusChecker\FiasStatusChecker;
use Liquetsoft\Fias\Component\FiasStatusChecker\FiasStatusCheckerResult;

/**
 * Консольная команда, которая проверяет и отображает текущий статус ФИАС.
 */
final class StatusCheckCommand extends Command
{
    protected $signature = 'liquetsoft:fias:status';

    protected $description = 'Shows information about current status of FIAS services.';

    public function __construct(private readonly FiasStatusChecker $statusChecker)
    {
        parent::__construct();
    }

    /**
     * Запуск команды на исполнение.
     */
    public function handle(): void
    {
        $status = $this->statusChecker->check();

        if ($status->canProceed()) {
            $this->info('FIAS is OK and available.');
        } else {
            $this->error('FIAS is not available.');
            $this->table(
                [
                    'Service',
                    'Status',
                    'Reason',
                ],
                $this->convertStatusToTableBody($status)
            );
        }
    }

    /**
     * @return array<int, array<int, string>>
     */
    private function convertStatusToTableBody(FiasStatusCheckerResult $status): array
    {
        $tableBody = [];

        foreach ($status->getPerServiceStatuses() as $serviceStatus) {
            $tableBody[] = [
                $serviceStatus->getService()->value,
                $serviceStatus->getStatus()->value,
                $serviceStatus->getReason(),
            ];
        }

        return $tableBody;
    }
}
