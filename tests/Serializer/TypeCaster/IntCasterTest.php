<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Serializer\TypeCaster;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster\IntCaster;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * @internal
 */
final class IntCasterTest extends BaseCase
{
    /**
     * Проверяет, что кастер правильно определит тип преобразования.
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('provideTestCanCast')]
    public function testCanCast(string $type, mixed $value, mixed $expected): void
    {
        $caster = new IntCaster();

        $res = $caster->canCast($type, $value);

        $this->assertSame($expected, $res);
    }

    public static function provideTestCanCast(): array
    {
        return [
            'int' => [
                'int',
                '',
                true,
            ],
            'integer' => [
                'integer',
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
        $caster = new IntCaster();

        $res = $caster->cast($type, $value);

        $this->assertSame($expected, $res);
    }

    public static function provideTestCast(): array
    {
        return [
            'float' => [
                'int',
                10.0,
                10,
            ],
            'int' => [
                'int',
                10,
                10,
            ],
            'string' => [
                'int',
                '10',
                10,
            ],
        ];
    }
}
