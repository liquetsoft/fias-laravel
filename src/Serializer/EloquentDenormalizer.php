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
final class EloquentDenormalizer implements DenormalizerInterface
{
    private readonly TypeCaster $typeCaster;

    public function __construct(?TypeCaster $typeCaster = null)
    {
        $this->typeCaster = $typeCaster ?? new EloquentTypeCaster();
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return is_subclass_of($type, Model::class);
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
        $data = \is_array($data) ? $data : [];
        $type = trim($type, " \t\n\r\0\x0B\\/");

        $entity = !empty($context['object_to_populate']) ? $context['object_to_populate'] : new $type();

        if (!($entity instanceof Model)) {
            throw new InvalidArgumentException("Bad class for populating entity, '" . Model::class . "' is required");
        }

        try {
            $dataArray = $this->createDataArrayForModel($data, $entity);
            $entity->fill($dataArray);
        } catch (\Throwable $e) {
            throw new NotNormalizableValueException(
                message: "Can't denormalize data to eloquent model",
                previous: $e
            );
        }

        return $entity;
    }

    /**
     * {@inheritDoc}
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            Model::class => true,
        ];
    }

    /**
     * Создает массив данных для вставки в модель на основании полей модели.
     */
    private function createDataArrayForModel(array $data, Model $entity): array
    {
        $dataArray = [];

        foreach ($data as $propertyName => $propertyValue) {
            $modelAttribute = $this->mapParameterNameToModelAttributeName((string) $propertyName, $entity);
            if ($modelAttribute !== null) {
                $modelValue = $this->castValueForModel($propertyValue, $modelAttribute, $entity);
                $dataArray[$modelAttribute] = $modelValue;
            }
        }

        return $dataArray;
    }

    /**
     * Пробует преобразовать имя параметра так, чтобы получить соответствие из модели.
     */
    private function mapParameterNameToModelAttributeName(string $name, Model $entity): ?string
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

        foreach ($entity->getFillable() as $field) {
            if (\in_array(strtolower($field), $nameVariants)) {
                $mappedName = $field;
                break;
            }
        }

        return $mappedName;
    }

    /**
     * Преобразует значение атрибута к тому типу, который указан в модели.
     */
    private function castValueForModel(mixed $value, string $attributeName, Model $entity): mixed
    {
        $type = (string) ($entity->getCasts()[$attributeName] ?? '');

        if ($value !== null && $this->typeCaster->canCast($type, $value)) {
            $value = $this->typeCaster->cast($type, $value);
        }

        return $value;
    }
}
