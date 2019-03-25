<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use Talevskiigor\ComposerBump\ComposerBump;

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

    public function version(BaseRequest $request)
    {
        return response()->json([
            'version' => (new ComposerBump)->getVersion()
        ]);
    }
}
