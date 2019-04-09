<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/5/2019
 * Time: 11:11 AM.
 */

namespace App\Http\Controllers;


use App\Http\Requests\Setting\UpdateRequest;
use App\Http\Requests\Setting\ViewRequest;
use App\Model\Setting;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SettingController extends Controller
{
    public function get(ViewRequest $request)
    {
        $setting = Setting::find($request->route('setting'));

        if ($setting === null) {
            throw new NotFoundHttpException('Setting not found');
        }

        return $setting->get();
    }

    public function save(UpdateRequest $request)
    {
        $validated = $request->validated();

        $setting = Setting::find($request->route('setting'));

        if ($setting === null) {
            throw new NotFoundHttpException('Setting not found');
        }

        $setting->set($validated['data']);

        return response()->json([
            'updated_at' => now()->format('Y-m-d H:i:s')
        ]);
    }
}
