<?php

namespace App\Http\Controllers;

use App\Bootstrap\Composer;
use App\Http\Requests\BaseRequest;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @param BaseRequest $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(BaseRequest $request)
    {
        return view('layouts.admin');
    }

    public function version(BaseRequest $request, Composer $composer)
    {
        return response()->json([
            'version' => $composer->getAppVersion()
        ]);
    }
}
