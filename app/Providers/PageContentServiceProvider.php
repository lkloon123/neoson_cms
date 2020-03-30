<?php

namespace App\Providers;

use App\Plugins\PluginManager;
use App\Views\Builder;
use App\Views\Theme;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class PageContentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Theme::class, function ($app) {
            return new Theme($app['config']->get('app.activated_theme'));
        });

        $this->app->singleton('page.content', function ($app) {
            $builder = new Builder($app[Theme::class], $app[PluginManager::class]);
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

}
