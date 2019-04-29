<?php

namespace App\Providers;

use App\Views\Asset;
use App\Views\Builder;
use App\Views\MenuBuilder;
use App\Views\Theme;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class PageContentServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('activatedTheme', function ($app) {
            return new Theme($app['setting']->get('activated_theme'));
        });

        $this->app->singleton('asset', function ($app) {
            return new Asset($app['activatedTheme']);
        });

        $this->app->singleton('menuBuilder', function ($app) {
            return new MenuBuilder($app['activatedTheme']);
        });

        $this->app->singleton('pageContent', function ($app) {
            $builder = new Builder($app['activatedTheme']);
            $view = $app['view'];
            $view->share('builder', $builder);
            return $builder;
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
        $loader->alias('PageContent', \App\Facade\PageContentFacade::class);
        $loader->alias('PageType', \App\Enums\PageType::class);
    }

    public function provides()
    {
        return ['activatedTheme', 'asset', 'menuBuilder', 'pageContent'];
    }

}
