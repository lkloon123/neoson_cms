<?php

namespace App\Providers;

use App\Bootstrap\Composer;
use App\Plugins\PluginLoader;
use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Composer::class, function ($app) {
            return new Composer($app['files'], $app->basePath());
        });

        $this->app->singleton(PluginLoader::class, function ($app) {
            return new PluginLoader(storage_path('app/plugins.json'), $app[Composer::class]);
        });

        app(PluginLoader::class)->registerAllPluginServiceProvider();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        app(PluginLoader::class)->bootAllPluginServiceProvider();
    }
}
