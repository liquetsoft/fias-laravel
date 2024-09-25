<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Serializer;

use Illuminate\Database\Eloquent\Model;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\EloquentDenormalizer;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster\TypeCaster;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel\FiasSerializerMock;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

/**
 * @internal
 */
final class EloquentDenormalizerTest extends BaseCase
{
    /**
     * Проверяет, что денормалайзер правильно определит, что может преобразовать тип.
     *
     * @dataProvider provideSupportsDenormalization
     */
    public function testSupportsDenormalization(string $type, bool $expected): void
    {
        $caster = $this->mock(TypeCaster::class);

        $denormalizer = new EloquentDenormalizer($caster);
        $res = $denormalizer->supportsDenormalization([], $type);

        $this->assertSame($expected, $res);
    }

    public static function provideSupportsDenormalization(): array
    {
        return [
            'supported type' => [
                FiasSerializerMock::class,
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
            'actstatid' => '100',
            '@name' => 'test',
            'FLOATNUM' => '10.2',
            'boolVal' => '1',
            'timestamp' => 120000,
            'nullableCast' => null,
            'wrong_attr' => 'wrong attr value',
        ];

        $denormalizer = new EloquentDenormalizer();
        $res = $denormalizer->denormalize($data, FiasSerializerMock::class);

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

        $denormalizer = new EloquentDenormalizer();
        $res = $denormalizer->denormalize(
            data: $data,
            type: FiasSerializerMock::class,
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
     * Проверяет, что денормалайзер выьросит исключение, если указана неверная модель для наполнения.
     */
    public function testDenormalizeWithObjectToPopulateException(): void
    {
        $data = [
            'actstatid' => '100',
        ];
        $model = new \stdClass();

        $denormalizer = new EloquentDenormalizer();

        $this->expectException(InvalidArgumentException::class);
        $denormalizer->denormalize(
            data: $data,
            type: FiasSerializerMock::class,
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

        $denormalizer = new EloquentDenormalizer($caster);

        $this->expectException(NotNormalizableValueException::class);
        $denormalizer->denormalize($data, FiasSerializerMock::class);
    }

    /**
     * Проверяет, что денормалайзер вернет верный список поддерживаемых объектов.
     */
    public function testGetSupportedTypes(): void
    {
        $expected = [
            Model::class => true,
        ];
        $caster = $this->mock(TypeCaster::class);

        $denormalizer = new EloquentDenormalizer($caster);
        $res = $denormalizer->getSupportedTypes(null);

        $this->assertSame($expected, $res);
    }
}
