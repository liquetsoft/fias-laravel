<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Liquetsoft\Fias\Component\EntityDescriptor\EntityDescriptor;
use Liquetsoft\Fias\Component\EntityField\EntityField;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PsrPrinter;
use SplFileInfo;

/**
 * Объект, который создает классы моделей из описания моделей в yaml.
 */
class ResourceGenerator extends AbstractGenerator
{
    /**
     * @inheritDoc
     */
    protected function generateClassByDescriptor(EntityDescriptor $descriptor, SplFileInfo $dir, string $namespace): void
    {
        $name = $this->unifyClassName($descriptor->getName());
        $fullPath = "{$dir->getPathname()}/{$name}.php";

        $phpFile = new PhpFile;
        $phpFile->setStrictTypes();

        $namespace = $phpFile->addNamespace($namespace);
        $this->decorateNamespace($namespace, $descriptor);

        $class = $namespace->addClass($name)->addExtend(JsonResource::class);
        $this->decorateClass($class, $descriptor);

        file_put_contents($fullPath, (new PsrPrinter)->printFile($phpFile));
    }

    /**
     * Добавляет все необходимые импорты в пространство имен.
     *
     * @param PhpNamespace     $namespace
     * @param EntityDescriptor $descriptor
     */
    protected function decorateNamespace(PhpNamespace $namespace, EntityDescriptor $descriptor): void
    {
        $namespace->addUse(JsonResource::class);
        $namespace->addUse(Request::class);
    }

    /**
     * Добавляет все необходимые для класса комментарии.
     *
     * @param ClassType        $class
     * @param EntityDescriptor $descriptor
     */
    protected function decorateClass(ClassType $class, EntityDescriptor $descriptor): void
    {
        $entityName = $this->unifyClassName($descriptor->getName());
        $class->addComment("Ресурс для сущности '{$entityName}'.");

        $toArray = [];
        foreach ($descriptor->getFields() as $field) {
            $this->decorateProperty($class, $field);
            $name = $this->unifyColumnName($field->getName());
            $toArray[] = "'{$name}' => \$this->{$name}";
        }
        $methodBody = "return[\n    " . implode(",\n    ", $toArray) . "\n];";

        $method = $class->addMethod('toArray')
            ->addComment("Преобразует сущность '{$entityName}' в массив.\n")
            ->addComment("@param Request \$request\n")
            ->addComment('@return array')
            ->setVisibility('public')
            ->setReturnType('array')
            ->setBody($methodBody);

        $method->addParameter('request');
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
                $varType = 'Carbon' . ($field->isNullable() ? '|null' : '');
                break;
            default:
                $varType = 'string' . ($field->isNullable() ? '|null' : '');
                break;
        }

        $class->addComment("@property {$varType} \${$name}");
    }
}