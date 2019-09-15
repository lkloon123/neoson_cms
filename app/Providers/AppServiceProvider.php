<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use OwenIt\Auditing\Models\Audit;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return (new Collection($value))->recursive();
                }
                return $value;
            });
        });

        $this->app->register(\Talevskiigor\ComposerBump\ComposerBumpServiceProvider::class);
        $this->app->register(HookServiceProvider::class);
        $this->app->register(PluginServiceProvider::class);
        $this->app->register(PageContentServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //database fix
        Schema::defaultStringLength(191);

        //dont save audit if values dint changed
        Audit::creating(function (Audit $model) {
            if (empty($model->old_values) && empty($model->new_values)) {
                return false;
            }
        });

        //dont append data on api resources
        Resource::withoutWrapping();

        //load all persistent setting to config ins
        foreach (Arr::dot(\Setting::all()) as $key => $value) {
            \Config::set($key, $value);
        }
    }
}
