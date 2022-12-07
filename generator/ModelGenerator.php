<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator;

use Illuminate\Database\Eloquent\Model;
use Liquetsoft\Fias\Component\EntityDescriptor\EntityDescriptor;
use Liquetsoft\Fias\Component\EntityField\EntityField;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpLiteral;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;

/**
 * Объект, который создает классы моделей из описания моделей в yaml.
 */
class ModelGenerator extends AbstractGenerator
{
    /**
     * {@inheritDoc}
     */
    protected function generateClassByDescriptor(EntityDescriptor $descriptor, \SplFileInfo $dir, string $namespace): void
    {
        $name = $this->unifyClassName($descriptor->getName());
        $fullPath = "{$dir->getPathname()}/{$name}.php";

        $phpFile = new PhpFile();
        $phpFile->setStrictTypes();

        $namespace = $phpFile->addNamespace($namespace);
        $this->decorateNamespace($namespace, $descriptor);

        $class = $namespace->addClass($name)->addExtend(Model::class);
        $this->decorateClass($class, $descriptor);

        file_put_contents($fullPath, (new PsrPrinter())->printFile($phpFile));
    }

    /**
     * Добавляет все необходимые импорты в пространство имен.
     *
     * @param PhpNamespace     $namespace
     * @param EntityDescriptor $descriptor
     */
    protected function decorateNamespace(PhpNamespace $namespace, EntityDescriptor $descriptor): void
    {
        $namespace->addUse(Model::class);
        foreach ($descriptor->getFields() as $field) {
            if ($field->getSubType() === 'date') {
                $namespace->addUse(\DateTimeInterface::class);
            }
        }
    }

    /**
     * Добавляет все необходимые для класса комментарии.
     *
     * @param ClassType        $class
     * @param EntityDescriptor $descriptor
     */
    protected function decorateClass(ClassType $class, EntityDescriptor $descriptor): void
    {
        $description = ucfirst(trim($descriptor->getDescription(), " \t\n\r\0\x0B."));
        if ($description) {
            $class->addComment("{$description}.\n");
        }

        $isPrimaryIsUuid = false;
        $primaryName = null;
        $fill = [];
        foreach ($descriptor->getFields() as $field) {
            $this->decorateProperty($class, $field);
            $fill[] = $this->unifyColumnName($field->getName());
            if ($field->isPrimary()) {
                $primaryName = $this->unifyColumnName($field->getName());
            }
            if ($field->isPrimary() && $field->getType() === 'string') {
                $isPrimaryIsUuid = true;
            }
        }

        $class->addProperty('timestamps', new PhpLiteral('false'))
            ->setVisibility('public')
            ->addComment('@var bool')
        ;

        $class->addProperty('incrementing', new PhpLiteral('false'))
            ->setVisibility('public')
            ->addComment('@var bool')
        ;

        $tableName = $this->convertClassnameToTableName($descriptor->getName());
        $class->addProperty('table', $tableName)
            ->setVisibility('protected')
            ->addComment('@var string')
        ;

        $class->addProperty('primaryKey', $primaryName)
            ->setVisibility('protected')
            ->addComment('@var string')
        ;

        if ($isPrimaryIsUuid) {
            $class->addProperty('keyType', 'string')
                ->setVisibility('protected')
                ->addComment('@var string')
            ;
        }

        $fillableValue = new PhpLiteral("[\n    '" . implode("',\n    '", $fill) . "',\n]");
        $class->addProperty('fillable', $fillableValue)
            ->setVisibility('protected')
            ->addComment('@var string[]')
        ;

        $castValue = new PhpLiteral($this->createCastValue($descriptor));
        $class->addProperty('casts', $castValue)
            ->setVisibility('protected')
            ->addComment('@var array')
        ;

        $connectionMethod = "\$connection = \$this->connection;\n";
        $connectionMethod .= "if (\\function_exists('app') && app()->has('config')) {\n";
        $connectionMethod .= "    /** @var string|null */\n";
        $connectionMethod .= "    \$connection = app('config')->get('liquetsoft_fias.eloquent_connection') ?: \$this->connection;\n";
        $connectionMethod .= "}\n\n";
        $connectionMethod .= 'return $connection;';
        $class->addMethod('getConnectionName')
            ->addComment("{@inheritDoc}\n\n@psalm-suppress MixedMethodCall")
            ->setBody($connectionMethod)
        ;
    }

    /**
     * Добавляет все свойства в формате phpDoc, поскольку в laravel они используют магию.
     *
     * @param ClassType   $class
     * @param EntityField $field
     */
    protected function decorateProperty(ClassType $class, EntityField $field): void
    {
        $name = $this->unifyColumnName($field->getName());
        $type = trim($field->getType() . '_' . $field->getSubType(), ' _');

        switch ($type) {
            case 'int':
                $varType = 'int' . ($field->isNullable() ? '|null' : '');
                break;
            case 'string_date':
                $varType = 'DateTimeInterface' . ($field->isNullable() ? '|null' : '');
                break;
            default:
                $varType = 'string' . ($field->isNullable() ? '|null' : '');
                break;
        }

        $description = '';
        if ($field->getDescription()) {
            $description = ' ' . $field->getDescription();
        }

        $class->addComment("@property {$varType} \${$name}{$description}");
    }

    /**
     * Создает массив для тайпкаста модели eloquent.
     */
    protected function createCastValue(EntityDescriptor $descriptor)
    {
        $types = "[\n";

        foreach ($descriptor->getFields() as $field) {
            $name = $this->unifyColumnName($field->getName());
            $type = trim($field->getType() . '_' . $field->getSubType(), ' _');
            switch ($type) {
                case 'int':
                    $castType = 'integer';
                    break;
                case 'string':
                case 'string_uuid':
                    $castType = 'string';
                    break;
                case 'string_date':
                    $castType = 'datetime';
                    break;
                default:
                    $castType = null;
                    break;
            }
            if ($castType) {
                $types .= "    '{$name}' => '{$castType}',\n";
            }
        }

        $types .= ']';

        return $types;
    }
}
