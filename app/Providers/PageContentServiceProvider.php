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
        $this->app->singleton('theme.activated', function ($app) {
            return new Theme($app['config']->get('activated_theme'));
        });

        $this->app->singleton('asset', function ($app) {
            return new Asset($app['theme.activated']);
        });

        $this->app->singleton('menu.builder', function ($app) {
            return new MenuBuilder($app['theme.activated']);
        });

        $this->app->singleton('page.content', function ($app) {
            $builder = new Builder($app['theme.activated']);
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
        return ['theme.activated', 'asset', 'menu.builder', 'page.content'];
    }

}
