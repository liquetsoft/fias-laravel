<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator;

use Illuminate\Database\Eloquent\Model;
use Liquetsoft\Fias\Component\EntityDescriptor\EntityDescriptor;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Объект, который создает класс для сериализатора сущностей ФИАС.
 */
class SerializerGenerator extends AbstractGenerator
{
    /**
     * {@inheritDoc}
     */
    protected function generate(\SplFileInfo $dir, string $namespace): void
    {
        $name = 'CompiledEntitesDenormalizer';
        $fullPath = "{$dir->getPathname()}/{$name}.php";

        $phpFile = new PhpFile();
        $phpFile->setStrictTypes();

        $namespace = $phpFile->addNamespace($namespace);
        $this->decorateNamespace($namespace);

        $class = $namespace->addClass($name)->setFinal()->addImplement(DenormalizerInterface::class);
        $this->decorateClass($class);

        file_put_contents($fullPath, (new PsrPrinter())->printFile($phpFile));
    }

    /**
     * Добавляет все необходимые импорты в пространство имен.
     */
    protected function decorateNamespace(PhpNamespace $namespace): void
    {
        $namespace->addUse(DenormalizerInterface::class);
        $namespace->addUse(AbstractNormalizer::class);
        $namespace->addUse(Model::class);
        $namespace->addUse(InvalidArgumentException::class);

        $descriptors = $this->registry->getDescriptors();
        foreach ($descriptors as $descriptor) {
            $namespace->addUse($this->createModelClass($descriptor));
            foreach ($descriptor->getFields() as $field) {
                if ($field->getSubType() === 'date') {
                    $namespace->addUse(\DateTimeImmutable::class);
                    break;
                }
            }
        }
    }

    /**
     * Добавляет в класс все необходимые методы и константы.
     */
    protected function decorateClass(ClassType $class): void
    {
        $constants = [];

        $denormalizeBody = "\$dataToPopulate = \$this->convertDataToInternalFormat(\$data);\n";
        $denormalizeBody .= '$type = trim($type, " \t\n\r\0\x0B\\\\/");' . "\n\n";
        $denormalizeBody .= "\$entity = \$context[AbstractNormalizer::OBJECT_TO_POPULATE] ?? new \$type();\n\n";
        $denormalizeBody .= "if (!(\$entity instanceof Model)) {\n";
        $denormalizeBody .= "    throw new InvalidArgumentException(\"Bad class for populating entity, '\" . Model::class . \"' is required\");\n";
        $denormalizeBody .= "}\n\n";
        $denormalizeBody .= "switch (\$type) {\n";

        $descriptors = $this->registry->getDescriptors();
        foreach ($descriptors as $descriptor) {
            $className = $this->unifyClassName($descriptor->getName());
            $constants[] = new Literal("{$className}::class => true");
            $denormalizeBody .= "    case {$className}::class:\n";
            $denormalizeBody .= "        \$extractedData = \$this->model{$className}DataExtractor(\$dataToPopulate);\n";
            $denormalizeBody .= "        break;\n";
        }

        $denormalizeBody .= "    default:\n";
        $denormalizeBody .= "        throw new InvalidArgumentException(\"Can't find data extractor for '{\$type}' type\");\n";
        $denormalizeBody .= "        break;\n";
        $denormalizeBody .= "}\n\n";
        $denormalizeBody .= "\$entity->setRawAttributes(\$extractedData);\n";
        $denormalizeBody .= "\n";
        $denormalizeBody .= 'return $entity;';

        $class->addComment('Скомпилированный класс для денормализации сущностей ФИАС в модели eloquent.');
        $class->addConstant('ALLOWED_ENTITIES', $constants)->setPrivate();

        $supports = $class->addMethod('supportsDenormalization')
            ->addComment("{@inheritDoc}\n")
            ->setVisibility('public')
            ->setReturnType('bool')
            ->setBody('return \\array_key_exists(trim($type, " \t\n\r\0\x0B\\\\/"), self::ALLOWED_ENTITIES);');
        $supports->addParameter('data');
        $supports->addParameter('type')->setType('string');
        $supports->addParameter('format', new Literal('null'))->setType('string');
        $supports->addParameter('context', new Literal('[]'))->setType('array');

        $denormalize = $class->addMethod('denormalize')
            ->addComment("{@inheritDoc}\n")
            ->addComment("@psalm-suppress InvalidStringClass\n")
            ->setVisibility('public')
            ->setReturnType('mixed')
            ->setBody($denormalizeBody);
        $denormalize->addParameter('data');
        $denormalize->addParameter('type')->setType('string');
        $denormalize->addParameter('format', new Literal('null'))->setType('string');
        $denormalize->addParameter('context', new Literal('[]'))->setType('array');

        $getSupportedTypes = $class->addMethod('getSupportedTypes')
            ->addComment("{@inheritDoc}\n")
            ->setVisibility('public')
            ->setReturnType('array')
            ->setBody('return self::ALLOWED_ENTITIES;');
        $getSupportedTypes->addParameter('format')->setType('string')->setNullable(true);

        $convertDataToInternalFormatBody = <<<EOT
\$result = [];
if (!is_array(\$data)) {
    return \$result;
}

foreach (\$data as \$key => \$value) {
    \$newKey = strtolower(trim((string) \$key, " \\n\\r\\t\\v\\x00@"));
    \$result[\$newKey] = \$value;
}

return \$result;
EOT;
        $convertDataToInternalFormat = $class->addMethod('convertDataToInternalFormat')
            ->setVisibility('private')
            ->setReturnType('array')
            ->setBody($convertDataToInternalFormatBody);
        $convertDataToInternalFormat->addParameter('data')->setType('mixed')->setNullable(false);

        foreach ($descriptors as $descriptor) {
            $className = $this->unifyClassName($descriptor->getName());
            $entityMethod = $class->addMethod("model{$className}DataExtractor");
            $this->decorateModelDataExtractor($entityMethod, $descriptor);
        }
    }

    /**
     * Создает метод для денормализации одной конкретной модели.
     */
    protected function decorateModelDataExtractor(Method $method, EntityDescriptor $descriptor): void
    {
        $className = $this->unifyClassName($descriptor->getName());

        $body = "return [\n";
        foreach ($descriptor->getFields() as $field) {
            $column = $this->unifyColumnName($field->getName());
            $type = trim($field->getType() . '_' . $field->getSubType(), ' _');
            switch ($type) {
                case 'int':
                    $varType = "(int) \$data['{$column}']";
                    break;
                case 'string_date':
                    $varType = "new DateTimeImmutable((string) \$data['{$column}'])";
                    break;
                default:
                    $varType = "trim((string) \$data['{$column}'])";
                    break;
            }
            $body .= "    '{$column}' => isset(\$data['{$column}']) ? {$varType} : null,\n";
        }
        $body .= '];';

        $method->addComment("Получает правильный массив данных для модели '{$className}'.\n");
        $method->addComment("@param array \$data\n");
        $method->addComment("@return array\n");
        $method->addParameter('data')->setType('array');
        $method->setVisibility('private');
        $method->setReturnType('array');
        $method->setBody($body);
    }

    /**
     * Создает имя класса для модели дескриптора.
     */
    protected function createModelClass(EntityDescriptor $descriptor): string
    {
        return 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Entity\\'
            . $this->unifyClassName($descriptor->getName());
    }

    /**
     * {@inheritDoc}
     */
    protected function generateClassByDescriptor(EntityDescriptor $descriptor, \SplFileInfo $dir, string $namespace): void
    {
    }
}
