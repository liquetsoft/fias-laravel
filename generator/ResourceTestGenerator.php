<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator;

use Illuminate\Http\Request;
use Liquetsoft\Fias\Component\EntityDescriptor\EntityDescriptor;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;

/**
 * Объект, который создает классы тестов для ресурсов моделей.
 */
class ResourceTestGenerator extends AbstractGenerator
{
    /**
     * {@inheritDoc}
     */
    protected function generateClassByDescriptor(EntityDescriptor $descriptor, \SplFileInfo $dir, string $namespace): void
    {
        $name = $this->unifyClassName($descriptor->getName());
        $testName = "{$name}Test";
        $fullPath = "{$dir->getPathname()}/{$testName}.php";

        $phpFile = new PhpFile();
        $phpFile->setStrictTypes();

        $namespace = $phpFile->addNamespace($namespace);
        $this->decorateNamespace($namespace, $descriptor);

        $class = $namespace->addClass($testName)->setFinal()->setExtends(BaseCase::class);
        $this->decorateClass($class, $descriptor);

        file_put_contents($fullPath, (new PsrPrinter())->printFile($phpFile));
    }

    /**
     * Добавляет все необходимые импорты в пространство имен.
     */
    protected function decorateNamespace(PhpNamespace $namespace, EntityDescriptor $descriptor): void
    {
        $hasDateTime = false;
        foreach ($descriptor->getFields() as $field) {
            if ($field->getSubType() === 'date') {
                $hasDateTime = true;
                break;
            }
        }

        $namespace->addUse(BaseCase::class);
        $namespace->addUse(Request::class);
        $namespace->addUse(\stdClass::class);
        $namespace->addUse(
            'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Resource\\' . $this->unifyClassName($descriptor->getName()),
            'Resource'
        );

        if ($hasDateTime) {
            $namespace->addUse(\DateTimeInterface::class);
        }
    }

    /**
     * Добавляет все необходимые для класса комментарии.
     */
    protected function decorateClass(ClassType $class, EntityDescriptor $descriptor): void
    {
        $entityName = $this->unifyClassName($descriptor->getName());
        $class->addComment("Тест ресурса для сущности '{$entityName}'.");

        $toArray = [];
        $toAssert = [];
        foreach ($descriptor->getFields() as $field) {
            $name = $this->unifyColumnName($field->getName());
            $type = trim($field->getType() . '_' . $field->getSubType(), ' _');

            $toAssert[] = "\$this->assertArrayHasKey('{$name}', \$array);";
            switch ($type) {
                case 'int':
                    $fake = '$this->createFakeData()->numberBetween(1, 1000000)';
                    $toAssert[] = "\$this->assertSame(\$model->{$name}, \$array['{$name}']);";
                    break;
                case 'string_uuid':
                    $fake = '$this->createFakeData()->uuid()';
                    $toAssert[] = "\$this->assertSame(\$model->{$name}, \$array['{$name}']);";
                    break;
                case 'string_date':
                    $fake = '$this->createFakeData()->dateTime()';
                    $toAssert[] = "\$this->assertSame(\$model->{$name}->format(DateTimeInterface::ATOM), \$array['{$name}']);";
                    break;
                default:
                    $fake = '$this->createFakeData()->word()';
                    $toAssert[] = "\$this->assertSame(\$model->{$name}, \$array['{$name}']);";
                    break;
            }

            $toArray[] = "\$model->{$name} = {$fake};";
        }
        $methodBody = "\$model = new stdClass();\n" . implode("\n", $toArray);
        $methodBody .= "\n\n\$resource = new Resource(\$model);";
        $methodBody .= "\n\$request = \$this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();";
        $methodBody .= "\n\$array = \$resource->toArray(\$request);";
        $methodBody .= "\n\n" . implode("\n", $toAssert);

        $method = $class->addMethod('testToArray')
            ->setReturnType('void')
            ->addComment("Проверяет, что ресурс верно преобразует сущность в массив.\n")
            ->setVisibility('public')
            ->setBody($methodBody);
    }
}
