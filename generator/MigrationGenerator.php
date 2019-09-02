<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Liquetsoft\Fias\Component\EntityDescriptor\EntityDescriptor;
use Liquetsoft\Fias\Component\EntityRegistry\EntityRegistry;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;
use SplFileInfo;

/**
 * Объект, который создает классы миграций из описания моделей в yaml.
 */
class MigrationGenerator extends AbstractGenerator
{
    /**
     * @var SplFileInfo
     */
    protected $currentStateYaml;

    /**
     * @param EntityRegistry $registry
     * @param SplFileInfo    $currentStateYaml
     */
    public function __construct(EntityRegistry $registry, SplFileInfo $currentStateYaml)
    {
        parent::__construct($registry);
        $this->currentStateYaml = $currentStateYaml;
    }

    /**
     * @inheritDoc
     */
    protected function generateClassByDescriptor(EntityDescriptor $descriptor, SplFileInfo $dir, string $namespace): void
    {
        $fileName = date('Y_m_d_His_') . $this->convertClassnameToTableName($descriptor->getName());
        $fullPath = "{$dir->getPathname()}/{$fileName}.php";
        $className = $this->unifyClassName($descriptor->getName()) . time();

        $phpFile = new PhpFile;
        $phpFile->setStrictTypes();
        $phpFile->addUse(Migration::class);
        $phpFile->addUse(Blueprint::class);
        $phpFile->addUse(Schema::class);

        $class = $phpFile->addClass($className)->addExtend(Migration::class);

        file_put_contents($fullPath, (new PsrPrinter)->printFile($phpFile));
    }
}
