<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Serializer\TypeCaster;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster\DateCaster;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * @internal
 */
final class DateCasterTest extends BaseCase
{
    /**
     * Проверяет, что кастер правильно определит тип преобразования.
     *
     * @dataProvider provideTestCanCast
     */
    public function testCanCast(string $type, mixed $value, mixed $expected): void
    {
        $caster = new DateCaster();

        $res = $caster->canCast($type, $value);

        $this->assertSame($expected, $res);
    }

    public static function provideTestCanCast(): array
    {
        return [
            'date' => [
                'date',
                '',
                true,
            ],
            'datetime' => [
                'datetime',
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
        $caster = new DateCaster();

        /** @var \DateTimeInterface */
        $res = $caster->cast($type, $value);

        $this->assertSame($expected, $res->format('Y-m-d H:i:s'));
    }

    public static function provideTestCast(): array
    {
        return [
            'date string' => [
                'date',
                '2023-10-10',
                '2023-10-10 00:00:00',
            ],
        ];
    }
}
