<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider для модуля.
 */
class LiquetsoftFiasBundleServiceProvider extends ServiceProvider
{
    /**
     * Регистрирует сервисы модуля в приложении.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Загружает данные модуля в приложение.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migration');
    }
}
