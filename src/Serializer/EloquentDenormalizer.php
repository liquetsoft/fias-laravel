<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer;

use Illuminate\Database\Eloquent\Model;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster\EloquentTypeCaster;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster\TypeCaster;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Нормализатор для объектов eloquent.
 */
class EloquentDenormalizer implements DenormalizerInterface
{
    /**
     * @var TypeCaster|null
     */
    protected $typeCaster;

    public function __construct(?TypeCaster $typeCaster = null)
    {
        if ($typeCaster === null) {
            $typeCaster = new EloquentTypeCaster();
        }

        $this->typeCaster = $typeCaster;
    }

    /**
     * {@inheritdoc}
     *
     * @throws NotNormalizableValueException
     *
     * @psalm-suppress InvalidStringClass
     */
    public function denormalize($data, $type, $format = null, array $context = [])
    {
        if (!\is_array($data)) {
            throw new InvalidArgumentException('Data for denormalization must be an array instance.');
        }

        $entity = !empty($context['object_to_populate']) ? $context['object_to_populate'] : new $type();

        if (!($entity instanceof Model)) {
            throw new InvalidArgumentException(
                "Bad class for populating entity, need '" . Model::class . "' instance.'"
            );
        }

        try {
            $dataArray = $this->createDataArrayForModel($data, $entity);
            $entity->fill($dataArray);
        } catch (\Throwable $e) {
            throw new NotNormalizableValueException(
                "Can't denormalize data to eloquent model.",
                0,
                $e
            );
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return is_subclass_of($type, Model::class);
    }

    /**
     * Создает массив данных для вставки в модель на основании полей модели.
     *
     * @param mixed[] $data
     *
     * @throws \Exception
     */
    protected function createDataArrayForModel(array $data, Model $entity): array
    {
        $dataArray = [];

        foreach ($data as $propertyName => $propertyValue) {
            $modelAttribute = $this->mapParameterNameToModelAttributeName((string) $propertyName, $entity);
            if ($modelAttribute === null) {
                continue;
            }
            $modelValue = $this->castValueForModel($propertyValue, $modelAttribute, $entity);
            $dataArray[$modelAttribute] = $modelValue;
        }

        return $dataArray;
    }

    /**
     * Пробует преобразовать имя параметра так, чтобы получить соответствие из модели.
     */
    protected function mapParameterNameToModelAttributeName(string $name, Model $entity): ?string
    {
        $mappedName = null;

        if (strpos($name, '@') === 0) {
            $name = substr($name, 1);
        }

        $nameVariants = [
            strtolower($name),
            str_replace('_', '', strtolower($name)),
            strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name)),
        ];

        /** @var string[] */
        $fields = $entity->getFillable();
        foreach ($fields as $field) {
            $loweredField = strtolower($field);
            if (\in_array($loweredField, $nameVariants)) {
                $mappedName = $field;
                break;
            }
        }

        return $mappedName;
    }

    /**
     * Преобразует значение атрибута к тому типу, который указан в модели.
     *
     * @throws \Exception
     */
    protected function castValueForModel($value, string $attributeName, Model $entity)
    {
        /** @var array<string, string> */
        $casts = $entity->getCasts();
        $type = $casts[$attributeName] ?? '';

        if ($value !== null && $this->typeCaster && $this->typeCaster->canCast($type, $value)) {
            $value = $this->typeCaster->cast($type, $value);
        }

        return $value;
    }
}
