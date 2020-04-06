<?php


namespace App\Providers;

use App\Service\TranslationLoaderService;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\TranslationServiceProvider as BaseTranslationServiceProvider;

class TranslationServiceProvider extends BaseTranslationServiceProvider
{
    protected function registerLoader()
    {
        $this->app->singleton('translation.loader', function ($app) {
            if (\Schema::hasTable('translations')) {
                return new TranslationLoaderService($app['files'], $app['path.lang']);
            }

            return new FileLoader($app['files'], $app['path.lang']);
        });
    }
}
