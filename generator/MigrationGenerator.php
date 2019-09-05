<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Liquetsoft\Fias\Component\EntityDescriptor\EntityDescriptor;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;
use SplFileInfo;

/**
 * Объект, который создает классы миграций из описания моделей в yaml.
 */
class MigrationGenerator extends AbstractGenerator
{
    /**
     * @inheritDoc
     */
    protected function generateClassByDescriptor(EntityDescriptor $descriptor, SplFileInfo $dir, string $namespace): void
    {
        $fileName = '2019_09_03_144400_' . $this->convertClassnameToTableName($descriptor->getName());
        $fullPath = "{$dir->getPathname()}/{$fileName}.php";
        $className = $this->unifyClassName($descriptor->getName()) . '20190903144400';

        $phpFile = new PhpFile;
        $phpFile->setStrictTypes();
        $phpFile->addUse(Migration::class);
        $phpFile->addUse(Blueprint::class);
        $phpFile->addUse(Schema::class);

        $class = $phpFile->addClass($className)->addExtend(Migration::class);
        $class->addComment("Миграция для создания сущности '{$descriptor->getName()}'.");
        $this->decorateClassWithUpMethodByDescription($class, $descriptor);
        $this->decorateClassWithDownMethodByDescription($class, $descriptor);

        file_put_contents($fullPath, (new PsrPrinter)->printFile($phpFile));
    }

    /**
     * Добавляет создание таблицы в класс миграции.
     *
     * @param ClassType        $class
     * @param EntityDescriptor $descriptor
     */
    protected function decorateClassWithUpMethodByDescription(ClassType $class, EntityDescriptor $descriptor): void
    {
        $tableName = $this->convertClassnameToTableName($descriptor->getName());

        $method = $class->addMethod('up')
            ->addComment("Создание таблицы '{$tableName}'.")
            ->setVisibility('public')
            ->setReturnType('void')
        ;

        $method->addBody("Schema::create('{$tableName}', function (Blueprint \$table) {");
        $method->addBody('    // создание полей таблицы');
        foreach ($descriptor->getFields() as $field) {
            $name = $this->unifyColumnName($field->getName());
            $type = trim($field->getType() . '_' . $field->getSubType(), ' _');

            switch ($type) {
                case 'int':
                    $migration = "\$table->unsignedInteger('{$name}')";
                    break;
                case 'string_date':
                    $migration = "\$table->datetime('{$name}')";
                    break;
                default:
                    $length = $field->getLength() ?: 255;
                    $migration = "\$table->string('{$name}', {$length})";
                    break;
            }
            if (!$field->isNullable()) {
                $migration .= '->nullable(false)';
            }
            if ($field->getDescription()) {
                $migration .= "->comment('" . addcslashes($field->getDescription(), "'") . "')";
            }
            $migration .= ';';
            $method->addBody("    {$migration}");
        }

        $method->addBody('    // создание индексов таблицы');
        foreach ($descriptor->getFields() as $field) {
            $name = $this->unifyColumnName($field->getName());
            if ($field->isPrimary()) {
                $method->addBody("    \$table->primary('{$name}');");
            }
            if ($field->isIndex()) {
                $method->addBody("    \$table->index('{$name}');");
            }
        }

        $method->addBody('});');
    }

    /**
     * Добавляет удаление таблицы в класс миграции.
     *
     * @param ClassType        $class
     * @param EntityDescriptor $descriptor
     */
    protected function decorateClassWithDownMethodByDescription(ClassType $class, EntityDescriptor $descriptor): void
    {
        $tableName = $this->convertClassnameToTableName($descriptor->getName());

        $class->addMethod('down')
            ->addComment("Удаление таблицы '{$tableName}'.")
            ->setVisibility('public')
            ->setReturnType('void')
            ->addBody("Schema::dropIfExists('{$tableName}');")
        ;
    }
}
