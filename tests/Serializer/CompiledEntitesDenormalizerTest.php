<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Serializer;

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
     *
     * @dataProvider provideSupportsDenormalization
     */
    public function testSupportsDenormalization(string $type, bool $expected): void
    {
        $denormalizer = new CompiledEntitesDenormalizer();
        $res = $denormalizer->supportsDenormalization([], $type);

        $this->assertSame($expected, $res);
    }

    public static function provideSupportsDenormalization(): array
    {
        return [
            'supported type' => [
                AddrObj::class,
                true,
            ],
            'unsupported type' => [
                'test',
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
        $res = $denormalizer->denormalize($data, AddrObj::class);

        $this->assertInstanceOf(AddrObj::class, $res);
        $this->assertSame((int) $data['@ID'], $res->getAttribute('id'));
        $this->assertSame((int) $data['@OBJECTID'], $res->getAttribute('objectid'));
        $this->assertSame($data['@OBJECTGUID'], $res->getAttribute('objectguid'));
        $this->assertNull($res->getAttribute('@PREVID'));
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
            context: [
                'object_to_populate' => $model,
            ]
        );

        $this->assertInstanceOf(AddrObj::class, $res);
        $this->assertSame($model, $res);
        $this->assertSame((int) $data['@ID'], $res->getAttribute('id'));
        $this->assertSame((int) $data['@OBJECTID'], $res->getAttribute('objectid'));
        $this->assertSame($data['@OBJECTGUID'], $res->getAttribute('objectguid'));
        $this->assertNull($res->getAttribute('@PREVID'));
    }

    /**
     * Проверяет, что денормалайзер выьросит исключение, если указана неверная модель для наполнения.
     */
    public function testDenormalizeWithObjectToPopulateException(): void
    {
        $data = [
            'id' => '100',
        ];
        $model = new \stdClass();

        $denormalizer = new CompiledEntitesDenormalizer();

        $this->expectException(InvalidArgumentException::class);
        $denormalizer->denormalize(
            data: $data,
            type: AddrObj::class,
            context: [
                'object_to_populate' => $model,
            ]
        );
    }

    /**
     * Проверяет, что денормалайзер вернет верный список поддерживаемых объектов.
     */
    public function testGetSupportedTypes(): void
    {
        $denormalizer = new CompiledEntitesDenormalizer();
        $res = $denormalizer->getSupportedTypes(null);

        $this->assertNotEmpty($res);
    }
}
