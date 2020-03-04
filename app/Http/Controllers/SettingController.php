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
use App\Http\Resources\SettingResource;
use App\Model\Setting;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SettingController extends Controller
{
    public function get(ViewRequest $request, $group)
    {
        $settings = Setting::getAllSettingFromGroup($group);

        if ($settings === null) {
            throw new NotFoundHttpException('Setting not found');
        }

        return SettingResource::collection($settings);
    }

    public function save(UpdateRequest $request, $group)
    {
        $validated = $request->validated();

        Setting::saveMultipleSettings($validated['data'], $group);

        return response()->json([
            'updated_at' => now()->format('Y-m-d H:i:s')
        ]);
    }
}
