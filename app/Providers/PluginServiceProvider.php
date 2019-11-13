<?php

namespace App\Providers;

use App\Bootstrap\Composer;
use App\Plugins\PluginLoader;
use App\Plugins\PluginManager;
use App\Plugins\UpdateManager;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use PhpZip\ZipFile;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend('composer', function ($composer, $app) {
            return new Composer($app['files'], $app->basePath());
        });

        $this->app->singleton('plugin.loader', function ($app) {
            return new PluginLoader(storage_path('app/plugins.json'));
        });

        $this->app->singleton('update.manager', function ($app) {
            return new UpdateManager(new ZipFile(), $app['composer'], $app['plugin.loader']);
        });

        $this->app->singleton('plugin.manager', function ($app) {
            return new PluginManager($app['plugin.loader'], $app['update.manager']);
        });

        app('plugin.loader')->registerAllPluginServiceProvider();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('UpdateManager', \App\Facade\UpdateManagerFacade::class);
        $loader->alias('PluginManager', \App\Facade\PluginManagerFacade::class);

        app('plugin.loader')->bootAllPluginServiceProvider();
    }
}
