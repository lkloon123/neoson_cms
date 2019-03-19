<?php

namespace App\Http\Controllers;

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
}
