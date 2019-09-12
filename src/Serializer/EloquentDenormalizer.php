<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer;

use DateTime;
use Exception;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Нормализатор для объектов eloquent.
 */
class EloquentDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws NotNormalizableValueException
     *
     * @psalm-suppress InvalidStringClass
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $entity = !empty($context['object_to_populate']) ? $context['object_to_populate'] : new $class;

        if (!($entity instanceof Model)) {
            throw new InvalidArgumentException(
                "Bad class for populating entity, need '" . Model::class . "' instance.'"
            );
        }

        try {
            $dataArray = $this->createDataArrayForModel($data, $entity);
        } catch (Throwable $e) {
            throw new NotNormalizableValueException(
                "Can't denormalize data to eloquent model.",
                0,
                $e
            );
        }
        $entity->fill($dataArray);

        return $entity;
    }

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        $eloquentClass = trim(Model::class, '\\');
        $dataClass = trim($type, '\\');

        return is_subclass_of($dataClass, $eloquentClass);
    }

    /**
     * Создает массив данных для вставки в модель на основании полей модели.
     *
     * @param array $data
     * @param Model $entity
     *
     * @return array
     *
     * @throws Exception
     */
    protected function createDataArrayForModel(array $data, Model $entity): array
    {
        $dataArray = [];

        foreach ($data as $propertyName => $propertyValue) {
            $modelAttribute = $this->mapParameterNameToModelAttributeName($propertyName, $entity);
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
     *
     * @param string $name
     * @param Model  $entity
     *
     * @return string|null
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

        $fields = $entity->getFillable();
        foreach ($fields as $field) {
            $loweredField = strtolower($field);
            if (in_array($loweredField, $nameVariants)) {
                $mappedName = $field;
                break;
            }
        }

        return $mappedName;
    }

    /**
     * Преобразует значение атрибута к тому типу, который указан в модели.
     *
     * @param mixed  $value
     * @param string $attributeName
     * @param Model  $entity
     *
     * @return mixed
     *
     * @throws Exception
     */
    protected function castValueForModel($value, string $attributeName, Model $entity)
    {
        $casts = $entity->getCasts();
        switch ($casts[$attributeName] ?? '') {
            case 'integer':
                $castedValue = (int) $value;
                break;
            case 'real':
            case 'float':
            case 'double':
                $castedValue = (float) $value;
                break;
            case 'string':
                $castedValue = (string) $value;
                break;
            case 'boolean':
                $castedValue = (bool) $value;
                break;
            case 'date':
            case 'datetime':
                $castedValue = new DateTime($value);
                break;
            case 'timestamp':
                $castedValue = is_numeric($value) ? (int) $value : (new DateTime($value))->getTimestamp();
                break;
            default:
                $castedValue = $value;
                break;
        }

        return $castedValue;
    }
}
