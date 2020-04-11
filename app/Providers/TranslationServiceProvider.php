<?php


namespace App\Providers;

use App\Service\TranslationLoaderService;
use App\Service\TranslatorService;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\TranslationServiceProvider as BaseTranslationServiceProvider;
use Illuminate\Translation\Translator;

class TranslationServiceProvider extends BaseTranslationServiceProvider
{
    public function register()
    {
        $this->registerLoader();

        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];

            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = $app['config']['app.locale'];

            $trans = new TranslatorService($loader, $locale);

            $trans->setFallback($app['config']['app.fallback_locale']);

            return $trans;
        });
    }

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
