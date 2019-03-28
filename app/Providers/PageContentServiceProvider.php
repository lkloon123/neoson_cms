<?php

namespace App\Providers;

use App\Views\Asset;
use App\Views\Builder;
use App\Views\MenuBuilder;
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
        $this->app->singleton('asset', function ($app) {
            return new Asset($app['setting']->get('activated_theme'));
        });

        $this->app->singleton('menuBuilder', function ($app) {
            return new MenuBuilder($app['setting']->get('activated_theme'));
        });

        $this->app->singleton('pageContent', function ($app) {
            $builder = new Builder($app['asset'], $app['setting']->get('activated_theme'));
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
        //
    }
}
