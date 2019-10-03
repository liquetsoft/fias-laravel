<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;
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
        $className = explode('_', $this->convertClassnameToTableName($descriptor->getName()));
        $className = implode('', array_map('ucfirst', $className));
        $className = $this->unifyClassName($className);

        $phpFile = new PhpFile;
        $phpFile->setStrictTypes();
        $phpFile->addUse(Migration::class);
        $phpFile->addUse(Blueprint::class);
        $phpFile->addUse(Schema::class);
        $phpFile->addUse(DB::class);
        $phpFile->addUse(Connection::class);

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

        $method->addBody("Schema::dropIfExists('{$tableName}');");
        $method->addBody("Schema::create('{$tableName}', function (Blueprint \$table) {");
        $method->addBody('    // создание полей таблицы');
        foreach ($descriptor->getFields() as $field) {
            $name = $this->unifyColumnName($field->getName());
            $type = trim($field->getType() . '_' . $field->getSubType(), ' _');

            switch ($type) {
                case 'int':
                    $migration = "\$table->unsignedInteger('{$name}')";
                    break;
                case 'string_uuid':
                    $migration = "\$table->uuid('{$name}')";
                    break;
                case 'string_date':
                    $migration = "\$table->datetime('{$name}')";
                    break;
                default:
                    $length = $field->getLength() ?: 255;
                    if ($length > 255) {
                        $migration = "\$table->text('{$name}')";
                    } else {
                        $migration = "\$table->string('{$name}', {$length})";
                    }
                    break;
            }
            if ($field->isNullable()) {
                $migration .= '->nullable(true)';
            } else {
                $migration .= '->nullable(false)';
            }
            if ($field->getDescription()) {
                $migration .= "->comment('" . addcslashes($field->getDescription(), "'") . "')";
            }
            if ($field->isPrimary()) {
                $migration .= '->primary()';
            }
            $migration .= ';';
            $method->addBody("    {$migration}");
        }

        $isIndexCommentAdded = false;
        foreach ($descriptor->getFields() as $field) {
            $name = $this->unifyColumnName($field->getName());
            if ($field->isIndex()) {
                if (!$isIndexCommentAdded) {
                    $method->addBody('    // создание индексов таблицы');
                    $isIndexCommentAdded = true;
                }
                $method->addBody("    \$table->index('{$name}');");
            }
        }

        $method->addBody('    // настройки таблицы');
        $method->addBody("    \$table->engine = 'InnoDB';");
        $method->addBody("    \$table->charset = 'utf8';");
        $method->addBody("    \$table->collation = 'utf8_unicode_ci';");

        $method->addBody('});');

        if ($descriptor->getPartitionsCount() > 1) {
            $partitioningPrimaries = [];
            $partitionFields = [];
            foreach ($descriptor->getFields() as $field) {
                $name = $this->unifyColumnName($field->getName());
                if ($field->isPartition()) {
                    $partitionFields[] = $name;
                    $partitioningPrimaries[] = $name;
                }
                if ($field->isPrimary()) {
                    $partitioningPrimaries[] = $name;
                }
            }
            $partitioningPrimaries = implode(', ', $partitioningPrimaries);
            $partitionFields = implode(', ', $partitionFields);
            $method->addBody("\n");
            $method->addBody('//для mysql большие таблицы нужно разбивать на части');
            $method->addBody('$connection = DB::connection();');
            $method->addBody("if (\$connection instanceof Connection && \$connection->getDriverName() === 'mysql') {");
            if ($partitionFields) {
                $method->addBody('    //поля для партицирования должны входить в каждый уникальный ключ, в т.ч. primary');
                $method->addBody("    DB::connection()->unprepared('ALTER TABLE {$tableName} DROP PRIMARY KEY');");
                $method->addBody("    DB::connection()->unprepared('ALTER TABLE {$tableName} ADD PRIMARY KEY({$partitioningPrimaries})');");
            }
            $method->addBody('    //разбиваем таблицу на части');
            $method->addBody("    DB::connection()->unprepared('ALTER TABLE {$tableName} PARTITION BY KEY({$partitionFields}) PARTITIONS {$descriptor->getPartitionsCount()};');");
            $method->addBody('}');
        }
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
