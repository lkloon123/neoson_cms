<?php

namespace App\Providers;

use App\Hook\HookManager;
use App\Hook\Hooks;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Hooks::class, function () {
            return new Hooks();
        });

        $this->app->singleton('hook.manager', function ($app) {
            return new HookManager($app[Hooks::class]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('HookManager', \App\Facade\HookManagerFacade::class);
    }
}
