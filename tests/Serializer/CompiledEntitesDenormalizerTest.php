<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Serializer;

use Liquetsoft\Fias\Component\Serializer\FiasSerializerFormat;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddrObj;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\CompiledEntitesDenormalizer;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;

/**
 * @internal
 */
final class CompiledEntitesDenormalizerTest extends BaseCase
{
    /**
     * Проверяет, что денормалайзер правильно определит, что может преобразовать тип.
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('provideSupportsDenormalization')]
    public function testSupportsDenormalization(string $type, string $format, bool $expected): void
    {
        $denormalizer = new CompiledEntitesDenormalizer();
        $res = $denormalizer->supportsDenormalization([], $type, $format);

        $this->assertSame($expected, $res);
    }

    public static function provideSupportsDenormalization(): array
    {
        return [
            'supported type and format' => [
                AddrObj::class,
                FiasSerializerFormat::XML->value,
                true,
            ],
            'unsupported type' => [
                'test',
                FiasSerializerFormat::XML->value,
                false,
            ],
            'unsupported format' => [
                AddrObj::class,
                'json',
                false,
            ],
        ];
    }

    /**
     * Проверяет, что денормалайзер правильно преобразует массив в модель.
     */
    public function testDenormalize(): void
    {
        $data = [
            '@ID' => '100',
            '@OBJECTID' => '101',
            '@OBJECTGUID' => '102',
            '@PREVID' => null,
        ];

        $denormalizer = new CompiledEntitesDenormalizer();
        $res = $denormalizer->denormalize($data, AddrObj::class, FiasSerializerFormat::XML->value);

        $this->assertInstanceOf(AddrObj::class, $res);
        $this->assertSame((int) $data['@ID'], $res->getAttribute('id'));
        $this->assertSame((int) $data['@OBJECTID'], $res->getAttribute('objectid'));
        $this->assertSame($data['@OBJECTGUID'], $res->getAttribute('objectguid'));
        $this->assertNull($res->getAttribute('previd'));
    }

    /**
     * Проверяет, что денормалайзер не будет обрабатывать данные, если предоставлен не массив.
     */
    public function testDenormalizeNotAnArrayException(): void
    {
        $denormalizer = new CompiledEntitesDenormalizer();

        $this->expectException(InvalidArgumentException::class);
        $denormalizer->denormalize(123, AddrObj::class, FiasSerializerFormat::XML->value);
    }

    /**
     * Проверяет, что денормалайзер правильно передаст массив в инициированную модель.
     */
    public function testDenormalizeWithObjectToPopulate(): void
    {
        $data = [
            '@ID' => '100',
            '@OBJECTID' => '101',
            '@OBJECTGUID' => '102',
            '@PREVID' => null,
        ];
        $model = new AddrObj();

        $denormalizer = new CompiledEntitesDenormalizer();
        $res = $denormalizer->denormalize(
            data: $data,
            type: AddrObj::class,
            format: FiasSerializerFormat::XML->value,
            context: [
                'object_to_populate' => $model,
            ]
        );

        $this->assertInstanceOf(AddrObj::class, $res);
        $this->assertSame($model, $res);
        $this->assertSame((int) $data['@ID'], $res->getAttribute('id'));
        $this->assertSame((int) $data['@OBJECTID'], $res->getAttribute('objectid'));
        $this->assertSame($data['@OBJECTGUID'], $res->getAttribute('objectguid'));
        $this->assertNull($res->getAttribute('previd'));
    }

    /**
     * Проверяет, что денормалайзер выьросит исключение, если указана неверная модель для наполнения.
     */
    public function testDenormalizeWithObjectToPopulateException(): void
    {
        $data = [
            '@ID' => '100',
        ];
        $model = new \stdClass();

        $denormalizer = new CompiledEntitesDenormalizer();

        $this->expectException(InvalidArgumentException::class);
        $denormalizer->denormalize(
            data: $data,
            type: AddrObj::class,
            format: FiasSerializerFormat::XML->value,
            context: [
                'object_to_populate' => $model,
            ]
        );
    }

    /**
     * Проверяет, что денормалайзер вернет верный список поддерживаемых объектов.
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('provideGetSupportedTypes')]
    public function testGetSupportedTypes(?string $format, array|true $expected): void
    {
        $denormalizer = new CompiledEntitesDenormalizer();
        $res = $denormalizer->getSupportedTypes($format);

        if ($expected === true) {
            $this->assertNotEmpty($res);
        } else {
            $this->assertSame($expected, $res);
        }
    }

    public static function provideGetSupportedTypes(): array
    {
        return [
            'xml format' => [
                FiasSerializerFormat::XML->value,
                true,
            ],
            'non xml format' => [
                'json',
                [],
            ],
        ];
    }
}
