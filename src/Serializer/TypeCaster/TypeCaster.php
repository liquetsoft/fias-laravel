<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\TypeCaster;

/**
 * Интерфейс для объекта, который приводит значение к определенному типу.
 */
interface TypeCaster
{
    /**
     * Проверяет подходит ли данный кастер к указанному типу данных.
     *
     * @param string $type
     * @param mixed  $value
     *
     * @return bool
     */
    public function canCast(string $type, $value): bool;

    /**
     * Приводит значение к указанному типу.
     *
     * @param string $type
     * @param mixed  $value
     *
     * @return mixed
     */
    public function cast(string $type, $value);
}
