<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformer;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformerResponse;
use Liquetsoft\Fias\Component\VersionManager\VersionManager;

/**
 * Консольная команда, которая принудительно задает номер текущей версии ФИАС.
 */
final class VersionSetCommand extends Command
{
    protected $signature = 'liquetsoft:fias:version_set {number : Number of new version}';

    protected $description = 'Sets number of current version of FIAS.';

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
        $number = $this->getNumber();

        $this->info("Setting '{$number}' FIAS version number");

        $version = $this->getVersion($number);
        $this->versionManager->setCurrentVersion($version);

        $this->info("'{$number}' FIAS version number set");
    }

    /**
     * Ищет указанную версию в списке на обновление и возвращает найденную.
     */
    private function getVersion(int $number): FiasInformerResponse
    {
        foreach ($this->informer->getAllVersions() as $version) {
            if ($version->getVersion() === $number) {
                return $version;
            }
        }

        throw new \InvalidArgumentException("Can't find '{$number}' version in list of all versions");
    }

    /**
     * Получает номер версии из параметров запуска команды.
     */
    private function getNumber(): int
    {
        $number = $this->argument('number');
        $number = \is_array($number) ? (int) reset($number) : (int) $number;

        if ($number <= 0) {
            throw new \InvalidArgumentException('Version number must integer instance more than 0');
        }

        return $number;
    }
}
