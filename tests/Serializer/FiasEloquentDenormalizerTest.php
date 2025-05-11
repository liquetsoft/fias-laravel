<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Serializer;

use Illuminate\Database\Eloquent\Model;
use Liquetsoft\Fias\Component\Serializer\FiasSerializerFormat;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\FiasEloquentDenormalizer;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster\TypeCaster;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel\FiasSerializerMock;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

/**
 * @internal
 */
final class FiasEloquentDenormalizerTest extends BaseCase
{
    /**
     * Проверяет, что денормалайзер правильно определит, что может преобразовать тип.
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('provideSupportsDenormalization')]
    public function testSupportsDenormalization(string $type, string $format, bool $expected): void
    {
        $caster = $this->mock(TypeCaster::class);

        $denormalizer = new FiasEloquentDenormalizer($caster);
        $res = $denormalizer->supportsDenormalization([], $type, $format);

        $this->assertSame($expected, $res);
    }

    public static function provideSupportsDenormalization(): array
    {
        return [
            'supported type and format' => [
                FiasSerializerMock::class,
                FiasSerializerFormat::XML->value,
                true,
            ],
            'unsupported type' => [
                'test',
                FiasSerializerFormat::XML->value,
                false,
            ],
            'unsupported format' => [
                FiasSerializerMock::class,
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
            'actstatid' => '100',
            '@name' => 'test',
            'FLOATNUM' => '10.2',
            'boolVal' => '1',
            'timestamp' => 120000,
            'nullableCast' => null,
            'wrong_attr' => 'wrong attr value',
        ];

        $denormalizer = new FiasEloquentDenormalizer();
        $res = $denormalizer->denormalize($data, FiasSerializerMock::class, FiasSerializerFormat::XML->value);

        $this->assertInstanceOf(FiasSerializerMock::class, $res);
        $this->assertSame((int) $data['actstatid'], $res->getAttribute('ACTSTATID'));
        $this->assertSame($data['@name'], $res->getAttribute('name'));
        $this->assertSame((float) $data['FLOATNUM'], $res->getAttribute('floatNum'));
        $this->assertSame((bool) $data['boolVal'], $res->getAttribute('boolVal'));
        $this->assertSame($data['timestamp'], $res->getAttribute('timestamp'));
        $this->assertNull($res->getAttribute('nullableCast'));
    }

    /**
     * Проверяет, что денормалайзер правильно передаст массив в инициированную модель.
     */
    public function testDenormalizeWithObjectToPopulate(): void
    {
        $data = [
            'actstatid' => '100',
            '@name' => 'test',
            'FLOATNUM' => '10.2',
            'boolVal' => '1',
            'timestamp' => 120000,
            'nullableCast' => null,
        ];
        $model = new FiasSerializerMock();

        $denormalizer = new FiasEloquentDenormalizer();
        $res = $denormalizer->denormalize(
            data: $data,
            type: FiasSerializerMock::class,
            format: FiasSerializerFormat::XML->value,
            context: [
                'object_to_populate' => $model,
            ]
        );

        $this->assertInstanceOf(FiasSerializerMock::class, $res);
        $this->assertSame($model, $res);
        $this->assertSame((int) $data['actstatid'], $res->getAttribute('ACTSTATID'));
        $this->assertSame($data['@name'], $res->getAttribute('name'));
        $this->assertSame((float) $data['FLOATNUM'], $res->getAttribute('floatNum'));
        $this->assertSame((bool) $data['boolVal'], $res->getAttribute('boolVal'));
        $this->assertSame($data['timestamp'], $res->getAttribute('timestamp'));
        $this->assertNull($res->getAttribute('nullableCast'));
    }

    /**
     * Проверяет, что денормалайзер не будет обрабатывать данные, если предоставлен не массив.
     */
    public function testDenormalizeNotAnArrayException(): void
    {
        $denormalizer = new FiasEloquentDenormalizer();

        $this->expectException(InvalidArgumentException::class);
        $denormalizer->denormalize(123, FiasSerializerMock::class, FiasSerializerFormat::XML->value);
    }

    /**
     * Проверяет, что денормалайзер выбросит исключение, если указана неверная модель для наполнения.
     */
    public function testDenormalizeWithObjectToPopulateException(): void
    {
        $data = [
            'actstatid' => '100',
        ];
        $model = new \stdClass();

        $denormalizer = new FiasEloquentDenormalizer();

        $this->expectException(InvalidArgumentException::class);
        $denormalizer->denormalize(
            data: $data,
            type: FiasSerializerMock::class,
            format: FiasSerializerFormat::XML->value,
            context: [
                'object_to_populate' => $model,
            ]
        );
    }

    /**
     * Проверяет, что денормалайзер переъватит исключение из кастера.
     */
    public function testDenormalizeNotNormalizableValueException(): void
    {
        $data = [
            'actstatid' => '100',
        ];

        $caster = $this->mock(TypeCaster::class);
        $caster->expects($this->once())
            ->method('canCast')
            ->willThrowException(new \RuntimeException());

        $denormalizer = new FiasEloquentDenormalizer($caster);

        $this->expectException(NotNormalizableValueException::class);
        $denormalizer->denormalize($data, FiasSerializerMock::class, FiasSerializerFormat::XML->value);
    }

    /**
     * Проверяет, что денормалайзер вернет верный список поддерживаемых объектов.
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('provideGetSupportedTypes')]
    public function testGetSupportedTypes(?string $format, array $expected): void
    {
        $caster = $this->mock(TypeCaster::class);

        $denormalizer = new FiasEloquentDenormalizer($caster);
        $res = $denormalizer->getSupportedTypes($format);

        $this->assertSame($expected, $res);
    }

    public static function provideGetSupportedTypes(): array
    {
        return [
            'xml format' => [
                FiasSerializerFormat::XML->value,
                [
                    Model::class => true,
                ],
            ],
            'null format' => [
                null,
                [],
            ],
            'json format' => [
                'json',
                [],
            ],
        ];
    }
}
