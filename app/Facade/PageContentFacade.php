<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/27/2019
 * Time: 9:41 AM.
 */

namespace App\Facade;


use Illuminate\Support\Facades\Facade;

class PageContentFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'page.content';
    }
}
