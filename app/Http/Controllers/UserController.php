<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/13/2019
 * Time: 11:25 AM.
 */

namespace App\Http\Controllers;

use Auth;

class UserController extends Controller
{
    public function getMe()
    {
        return Auth::user()->makeHidden('last_login_ip');
    }
}
