<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Illuminate\Console\Command;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformer;
use Liquetsoft\Fias\Component\FiasInformer\InformerResponse;
use Liquetsoft\Fias\Component\VersionManager\VersionManager;

/**
 * Консольная команда, которая принудительно задает номер текущей версии ФИАС.
 */
class VersionSetCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'liquetsoft:fias:version_set {number : Number of new version}';

    /**
     * @var string
     */
    protected $description = 'Sets number of current version of FIAS.';

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
        $number = $this->getNumber();

        $this->info("Setting '{$number}' FIAS version number.");

        $version = $this->getVersion($number);
        $this->versionManager->setCurrentVersion($version);

        $this->info("'{$number}' FIAS version number set.");
    }

    /**
     * Ищет указанную версию в списке на обновление и возвращает найденную.
     *
     * @return InformerResponse
     */
    private function getVersion(int $number): InformerResponse
    {
        $version = null;

        $deltaVersions = $this->informer->getDeltaList();
        foreach ($deltaVersions as $deltaVersion) {
            if ($deltaVersion->getVersion() === $number) {
                $version = $deltaVersion;
                break;
            }
        }

        if ($version === null) {
            $message = sprintf("Can't find '%s' version in list of deltas.", $number);
            throw new \InvalidArgumentException($message);
        }

        return $version;
    }

    /**
     * Получает номер версии из параметров запуска команды.
     *
     * @return int
     */
    private function getNumber(): int
    {
        $number = $this->argument('number');
        $number = \is_array($number) ? (int) reset($number) : (int) $number;
        if ($number <= 0) {
            throw new \InvalidArgumentException('Version number must integer instance more than 0.');
        }

        return $number;
    }
}
