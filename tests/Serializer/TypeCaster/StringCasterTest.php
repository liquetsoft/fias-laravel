<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Serializer\TypeCaster;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster\StringCaster;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * @internal
 */
final class StringCasterTest extends BaseCase
{
    /**
     * Проверяет, что кастер правильно определит тип преобразования.
     *
     * @dataProvider provideTestCanCast
     */
    public function testCanCast(string $type, mixed $value, mixed $expected): void
    {
        $caster = new StringCaster();

        $res = $caster->canCast($type, $value);

        $this->assertSame($expected, $res);
    }

    public static function provideTestCanCast(): array
    {
        return [
            'str' => [
                'str',
                '',
                true,
            ],
            'string' => [
                'string',
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
        $caster = new StringCaster();

        $res = $caster->cast($type, $value);

        $this->assertSame($expected, $res);
    }

    public static function provideTestCast(): array
    {
        return [
            'float' => [
                'string',
                10.2,
                '10.2',
            ],
            'int' => [
                'string',
                10,
                '10',
            ],
            'string' => [
                'string',
                '10',
                '10',
            ],
        ];
    }
}
