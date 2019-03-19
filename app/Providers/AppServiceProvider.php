<?php

namespace App\Providers;

use App\Model\Page;
use Illuminate\Http\Resources\Json\Resource;
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
        //
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

        //authorization setup
        \Bouncer::ownedVia(Page::class, 'author_id');
    }
}
