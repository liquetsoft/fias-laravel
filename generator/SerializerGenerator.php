<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Generator;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Liquetsoft\Fias\Component\EntityDescriptor\EntityDescriptor;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpLiteral;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use SplFileInfo;
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
    protected function generate(SplFileInfo $dir, string $namespace): void
    {
        $name = 'CompiledEntitesDenormalizer';
        $fullPath = "{$dir->getPathname()}/{$name}.php";

        $phpFile = new PhpFile();
        $phpFile->setStrictTypes();

        $namespace = $phpFile->addNamespace($namespace);
        $this->decorateNamespace($namespace);

        $class = $namespace->addClass($name)->addImplement(DenormalizerInterface::class);
        $this->decorateClass($class);

        file_put_contents($fullPath, (new PsrPrinter())->printFile($phpFile));
    }

    /**
     * Добавляет все необходимые импорты в пространство имен.
     *
     * @param PhpNamespace $namespace
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
                    $namespace->addUse(Carbon::class);
                    break;
                }
            }
        }
    }

    /**
     * Добавляет в класс все необходимые методы и константы.
     *
     * @param ClassType $class
     */
    protected function decorateClass(ClassType $class): void
    {
        $constants = [];

        $denormalizeBody = '$data = \\is_array($data) ? $data : [];' . "\n";
        $denormalizeBody .= '$type = trim($type, " \t\n\r\0\x0B\\\\/");' . "\n\n";
        $denormalizeBody .= "\$entity = \$context[AbstractNormalizer::OBJECT_TO_POPULATE] ?? new \$type();\n\n";
        $denormalizeBody .= "if (!(\$entity instanceof Model)) {\n";
        $denormalizeBody .= "    \$message = sprintf(\"Bad class for populating entity, need '%s' instance.\", Model::class);\n";
        $denormalizeBody .= "    throw new InvalidArgumentException(\$message);\n";
        $denormalizeBody .= "}\n\n";
        $denormalizeBody .= "switch (\$type) {\n";

        $descriptors = $this->registry->getDescriptors();
        foreach ($descriptors as $descriptor) {
            $className = $this->unifyClassName($descriptor->getName());
            $constants[] = new PhpLiteral("{$className}::class");
            $denormalizeBody .= "    case {$className}::class:\n";
            $denormalizeBody .= "        \$extractedData = \$this->model{$className}DataExtractor(\$data);\n";
            $denormalizeBody .= "        break;\n";
        }

        $denormalizeBody .= "    default:\n";
        $denormalizeBody .= "        \$message = sprintf(\"Can't find data extractor for '%s' type.\", \$type);\n";
        $denormalizeBody .= "        throw new InvalidArgumentException(\$message);\n";
        $denormalizeBody .= "        break;\n";
        $denormalizeBody .= "}\n\n";
        $denormalizeBody .= "\$entity->fill(\$extractedData);\n";
        $denormalizeBody .= "\n";
        $denormalizeBody .= 'return $entity;';

        $class->addComment('Скомпилированный класс для денормализации сущностей ФИАС в модели eloquent.');
        $class->addConstant('ALLOWED_ENTITIES', $constants)->setPrivate();

        $supports = $class->addMethod('supportsDenormalization')
            ->addComment("{@inheritDoc}\n")
            ->setVisibility('public')
            ->setBody('return \\in_array(trim($type, " \t\n\r\0\x0B\\\\/"), self::ALLOWED_ENTITIES);');
        $supports->addParameter('data');
        $supports->addParameter('type')->setType('string');
        $supports->addParameter('format', new PhpLiteral('null'))->setType('string');

        $denormalize = $class->addMethod('denormalize')
            ->addComment("{@inheritDoc}\n")
            ->addComment("@psalm-suppress InvalidStringClass\n")
            ->setVisibility('public')
            ->setBody($denormalizeBody);
        $denormalize->addParameter('data');
        $denormalize->addParameter('type')->setType('string');
        $denormalize->addParameter('format', new PhpLiteral('null'))->setType('string');
        $denormalize->addParameter('context', new PhpLiteral('[]'))->setType('array');

        foreach ($descriptors as $descriptor) {
            $className = $this->unifyClassName($descriptor->getName());
            $entityMethod = $class->addMethod("model{$className}DataExtractor");
            $this->decorateModelDataExtractor($entityMethod, $descriptor);
        }
    }

    /**
     * Создает метод для денормализации одной конкретной модели.
     *
     * @param Method           $method
     * @param EntityDescriptor $descriptor
     */
    protected function decorateModelDataExtractor(Method $method, EntityDescriptor $descriptor): void
    {
        $className = $this->unifyClassName($descriptor->getName());

        $body = "return [\n";
        foreach ($descriptor->getFields() as $field) {
            $column = $this->unifyColumnName($field->getName());
            $xmlAttribute = '@' . strtoupper($column);
            $type = trim($field->getType() . '_' . $field->getSubType(), ' _');
            switch ($type) {
                case 'int':
                    $varType = "(int) \$data['{$xmlAttribute}']";
                    break;
                case 'string_date':
                    $varType = "Carbon::parse(trim(\$data['{$xmlAttribute}']))";
                    break;
                default:
                    $varType = "trim(\$data['{$xmlAttribute}'])";
                    break;
            }
            $body .= "    '{$column}' => isset(\$data['{$xmlAttribute}']) ? {$varType} : null,\n";
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
     *
     * @param EntityDescriptor $descriptor
     *
     * @return string
     */
    protected function createModelClass(EntityDescriptor $descriptor): string
    {
        return 'Liquetsoft\\Fias\\Laravel\\LiquetsoftFiasBundle\\Entity\\'
            . $this->unifyClassName($descriptor->getName());
    }

    /**
     * {@inheritDoc}
     */
    protected function generateClassByDescriptor(EntityDescriptor $descriptor, SplFileInfo $dir, string $namespace): void
    {
    }
}
