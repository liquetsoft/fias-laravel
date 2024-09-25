<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Serializer\TypeCaster;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster\BoolCaster;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * @internal
 */
final class BoolCasterTest extends BaseCase
{
    /**
     * Проверяет, что кастер правильно определит тип преобразования.
     *
     * @dataProvider provideTestCanCast
     */
    public function testCanCast(string $type, mixed $value, mixed $expected): void
    {
        $caster = new BoolCaster();

        $res = $caster->canCast($type, $value);

        $this->assertSame($expected, $res);
    }

    public static function provideTestCanCast(): array
    {
        return [
            'bool' => [
                'bool',
                '',
                true,
            ],
            'boolean' => [
                'boolean',
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
     *
     * @dataProvider provideTestCast
     */
    public function testCast(string $type, mixed $value, mixed $expected): void
    {
        $caster = new BoolCaster();

        $res = $caster->cast($type, $value);

        $this->assertSame($expected, $res);
    }

    public static function provideTestCast(): array
    {
        return [
            'bool false' => [
                'bool',
                false,
                false,
            ],
            'bool true' => [
                'bool',
                true,
                true,
            ],
            'bool int 0' => [
                'bool',
                0,
                false,
            ],
            'bool int 1' => [
                'bool',
                1,
                true,
            ],
        ];
    }
}
