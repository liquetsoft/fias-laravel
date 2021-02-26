<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Liquetsoft\Fias\Component\FiasStatusChecker\FiasStatusChecker;

/**
 * Консольная команда, которая проверяет и отображает текущий статус ФИАС.
 */
class StatusCheckCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'liquetsoft:fias:status';

    /**
     * @var string|null
     */
    protected $description = 'Shows information about current status of FIAS services.';

    /**
     * @var FiasStatusChecker
     */
    private $statusChecker;

    public function __construct(FiasStatusChecker $statusChecker)
    {
        parent::__construct();

        $this->statusChecker = $statusChecker;
    }

    /**
     * Запуск команды на исполнение.
     */
    public function handle(): void
    {
        $status = $this->statusChecker->check();

        if ($status->getResultStatus() === FiasStatusChecker::STATUS_AVAILABLE) {
            $this->info('FIAS is OK and available.');
        } else {
            $this->error('FIAS is not available.');
            $this->table(['Service', 'Status', 'Reason'], $status->getPerServiceStatuses());
        }
    }
}
