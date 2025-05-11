<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Serializer\TypeCaster;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster\FloatCaster;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * @internal
 */
final class FloatCasterTest extends BaseCase
{
    /**
     * Проверяет, что кастер правильно определит тип преобразования.
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('provideTestCanCast')]
    public function testCanCast(string $type, mixed $value, mixed $expected): void
    {
        $caster = new FloatCaster();

        $res = $caster->canCast($type, $value);

        $this->assertSame($expected, $res);
    }

    public static function provideTestCanCast(): array
    {
        return [
            'real' => [
                'real',
                '',
                true,
            ],
            'float' => [
                'float',
                '',
                true,
            ],
            'double' => [
                'double',
                '',
                true,
            ],
            'decimal' => [
                'decimal',
                '',
                true,
            ],
            'random string' => [
                'test',
                '',
                false,
            ],
        ];
    }

    /**
     * Проверяет, что кастер правильно преобразует значение.
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('provideTestCast')]
    public function testCast(string $type, mixed $value, mixed $expected): void
    {
        $caster = new FloatCaster();

        $res = $caster->cast($type, $value);

        $this->assertSame($expected, $res);
    }

    public static function provideTestCast(): array
    {
        return [
            'float' => [
                'float',
                10.0,
                10.0,
            ],
            'int' => [
                'float',
                10,
                10.0,
            ],
            'string' => [
                'float',
                '10.0',
                10.0,
            ],
        ];
    }
}
