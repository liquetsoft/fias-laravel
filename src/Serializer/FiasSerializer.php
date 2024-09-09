<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer;

use Liquetsoft\Fias\Component\Serializer\FiasNameConverter;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Преднастроенный объект сериализатора для ФИАС.
 */
class FiasSerializer extends Serializer
{
    /**
     * @param array<DenormalizerInterface|NormalizerInterface>|null $normalizers
     * @param array<DecoderInterface|EncoderInterface>|null         $encoders
     */
    public function __construct(?array $normalizers = null, ?array $encoders = null)
    {
        if ($normalizers === null) {
            $normalizers = [
                new CompiledEntitesDenormalizer(),
                new ObjectNormalizer(
                    null,
                    new FiasNameConverter(),
                    null,
                    new ReflectionExtractor(),
                    null,
                    null,
                    [
                        ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true,
                    ]
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
