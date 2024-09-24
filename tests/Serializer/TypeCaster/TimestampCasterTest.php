<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Serializer\TypeCaster;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster\TimestampCaster;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * @internal
 */
final class TimestampCasterTest extends BaseCase
{
    /**
     * Проверяет, что кастер правильно определит тип преобразования.
     *
     * @dataProvider provideTestCanCast
     */
    public function testCanCast(string $type, mixed $value, mixed $expected): void
    {
        $caster = new TimestampCaster();

        $res = $caster->canCast($type, $value);

        $this->assertSame($expected, $res);
    }

    public static function provideTestCanCast(): array
    {
        return [
            'timestamp' => [
                'timestamp',
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
        $caster = new TimestampCaster();

        $res = $caster->cast($type, $value);

        $this->assertSame($expected, $res);
    }

    public static function provideTestCast(): array
    {
        return [
            'int' => [
                'timestamp',
                100000,
                100000,
            ],
            'string' => [
                'string',
                '2023-10-10',
                1696892400,
            ],
        ];
    }
}
