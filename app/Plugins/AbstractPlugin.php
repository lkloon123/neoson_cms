<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/29/2019
 * Time: 4:33 PM.
 */

namespace App\Plugins;


use Illuminate\Support\ServiceProvider;

abstract class AbstractPlugin extends ServiceProvider
{
    public $id;
    public $isDisabled = false;
    public $requires = [];

    abstract public function pluginInformation();

    public function registerMiddleware()
    {
        return [
            //global => [SomeMiddleware::class]
            //group  => [SomeMiddleware::class]
            //route  => [SomeMiddleware::class]
        ];
    }
}
