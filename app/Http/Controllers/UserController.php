<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/13/2019
 * Time: 11:25 AM.
 */

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function getMe()
    {
        return new UserResource(\Auth::user());
    }
}
