<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator;

use Liquetsoft\Fias\Component\EntityDescriptor\EntityDescriptor;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;

/**
 * Объект, который создает классы тестов для моделей из описания моделей в yaml.
 */
class ModelTestGenerator extends AbstractGenerator
{
    /**
     * {@inheritDoc}
     */
    protected function generateClassByDescriptor(EntityDescriptor $descriptor, \SplFileInfo $dir, string $namespace): void
    {
        $name = $this->unifyClassName($descriptor->getName()) . 'Test';
        $fullPath = "{$dir->getPathname()}/{$name}.php";

        $phpFile = new PhpFile();
        $phpFile->setStrictTypes();

        $namespace = $phpFile->addNamespace($namespace);
        $this->decorateNamespace($namespace, $descriptor);

        $class = $namespace->addClass($name)->setFinal()->setExtends(BaseCase::class);
        $this->decorateClass($class, $descriptor);

        file_put_contents($fullPath, (new PsrPrinter())->printFile($phpFile));
    }

    /**
     * Добавляет все необходимые импорты в пространство имен.
     */
    protected function decorateNamespace(PhpNamespace $namespace, EntityDescriptor $descriptor): void
    {
        $modelName = 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Entity\\' . $this->unifyClassName($descriptor->getName());
        $namespace->addUse($modelName);
        $namespace->addUse(BaseCase::class);
    }

    /**
     * Добавляет все необходимые для класса комментарии.
     */
    protected function decorateClass(ClassType $class, EntityDescriptor $descriptor): void
    {
        $modelName = $this->unifyClassName($descriptor->getName());
        $tableName = $this->convertClassnameToTableName($descriptor->getName());

        $class->addComment("Тест для модели '{$modelName}'.\n\n@internal\n");

        $class->addMethod('testGetTable')
            ->setVisibility('public')
            ->addComment('Проверяет, что модель привязана к правильной таблице в базе.')
            ->addBody("\$model = new {$modelName}();\n")
            ->addBody("\$this->assertSame('{$tableName}', \$model->getTable());")
            ->setReturnType('void')
        ;

        $fillable = [];
        $isPrimaryIsUuid = false;
        foreach ($descriptor->getFields() as $field) {
            $name = $this->unifyColumnName($field->getName());
            $fillable[] = "\$this->assertContains('{$name}', \$fields);";
            if ($field->isPrimary() && $field->getSubType() === 'uuid') {
                $isPrimaryIsUuid = true;
            }
        }

        $class->addMethod('testGetFillable')
            ->setVisibility('public')
            ->addComment('Проверяет, что в модели доступны для заполнения все поля.')
            ->setReturnType('void')
            ->addBody("\$model = new {$modelName}();")
            ->addBody("\$fields = \$model->getFillable();\n")
            ->addBody(implode("\n", $fillable))
        ;

        $class->addMethod('testGetIncrementing')
            ->setVisibility('public')
            ->setReturnType('void')
            ->addComment('Проверяет, что в модель не исрользует autoincrement.')
            ->addBody("\$model = new {$modelName}();\n")
            ->addBody('$this->assertFalse($model->getIncrementing());')
        ;

        if ($isPrimaryIsUuid) {
            $class->addMethod('testGetKeyType')
                ->setVisibility('public')
                ->setReturnType('void')
                ->addComment('Проверяет, что в модели правильно задана обработка первичного ключа.')
                ->addBody("\$model = new {$modelName}();\n")
                ->addBody('$this->assertSame(\'string\', $model->getKeyType());')
            ;
        }
    }
}
