<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Serializer\TypeCaster;

use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster\EloquentTypeCaster;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster\TypeCaster;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;

/**
 * @internal
 */
final class EloquentTypeCasterTest extends BaseCase
{
    /**
     * Проверяет, что кастер правильно определит тип преобразования.
     */
    public function testCanCast(): void
    {
        $type = 'type';
        $value = 123;

        $caster1 = $this->mock(TypeCaster::class);
        $caster1->expects($this->once())
            ->method('canCast')
            ->with(
                $this->identicalTo($type),
                $this->identicalTo($value),
            )
            ->willReturn(true);

        $caster2 = $this->mock(TypeCaster::class);
        $caster2->expects($this->never())->method('canCast');

        $caster = new EloquentTypeCaster([$caster1, $caster2]);

        $res = $caster->canCast($type, $value);

        $this->assertTrue($res);
    }

    /**
     * Проверяет, что кастер правильно определит тип преобразования.
     */
    public function testCanNotCast(): void
    {
        $type = 'type';
        $value = 123;

        $caster1 = $this->mock(TypeCaster::class);
        $caster1->expects($this->once())
            ->method('canCast')
            ->with(
                $this->identicalTo($type),
                $this->identicalTo($value),
            )
            ->willReturn(false);

        $caster2 = $this->mock(TypeCaster::class);
        $caster2->expects($this->once())
            ->method('canCast')
            ->with(
                $this->identicalTo($type),
                $this->identicalTo($value),
            )
            ->willReturn(false);

        $caster = new EloquentTypeCaster([$caster1, $caster2]);

        $res = $caster->canCast($type, $value);

        $this->assertFalse($res);
    }

    /**
     * Проверяет, что кастер правильно преобразует значение.
     */
    public function testCast(): void
    {
        $type = 'type';
        $value = 123;
        $castedValue = '123';

        $caster1 = $this->mock(TypeCaster::class);
        $caster1->expects($this->once())
            ->method('canCast')
            ->with(
                $this->identicalTo($type),
                $this->identicalTo($value),
            )
            ->willReturn(true);
        $caster1->expects($this->once())
            ->method('cast')
            ->with(
                $this->identicalTo($type),
                $this->identicalTo($value),
            )
            ->willReturn($castedValue);

        $caster2 = $this->mock(TypeCaster::class);
        $caster2->expects($this->never())->method('canCast');
        $caster2->expects($this->never())->method('cast');

        $caster = new EloquentTypeCaster([$caster1, $caster2]);

        $res = $caster->cast($type, $value);

        $this->assertSame($castedValue, $res);
    }
}
