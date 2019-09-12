<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Liquetsoft\Fias\Component\Serializer\FiasNameConverter;

/**
 * Преднастроенный объект сериализатора для ФИАС.
 */
class FiasSerializer extends Serializer
{
    /**
     * @param array|null $normalizers
     * @param array|null $encoders
     */
    public function __construct(?array $normalizers = null, ?array $encoders = null)
    {
        if ($normalizers === null) {
            $normalizers = [
                new EloquentDenormalizer(),
                new ObjectNormalizer(
                    null,
                    new FiasNameConverter,
                    null,
                    new ReflectionExtractor,
                    null,
                    null,
                    [ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true]
                ),
            ];
        }

        if ($encoders === null) {
            $encoders = [
                new XmlEncoder(),
            ];
        }

        parent::__construct($normalizers, $encoders);
    }
}
