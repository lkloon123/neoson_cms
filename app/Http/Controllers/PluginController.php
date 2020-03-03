<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/30/2019
 * Time: 4:42 PM.
 */

namespace App\Http\Controllers;


use App\Http\Requests\Plugin\CreateRequest;
use App\Http\Requests\Plugin\DeleteRequest;
use App\Http\Requests\Plugin\UpdateRequest;
use App\Http\Resources\PluginResource;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class PluginController extends Controller
{
    public function index()
    {
        return PluginResource::collection(\PluginManager::getAllPlugin()->values());
    }

    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();

        if ($validated['isDisabled'] === true) {
            $result = \PluginManager::disablePlugin($id);
        } else {
            $result = \PluginManager::enablePlugin($id);
        }

        if (!$result) {
            throw new NotAcceptableHttpException('plugin is already ' . ($validated['isDisabled'] ? 'disabled' : 'enabled'));
        }

        return response()->json([
            'id' => $id,
            'updated_at' => now()->format('Y-m-d H:i:s')
        ]);
    }

    public function store(CreateRequest $request)
    {
        \PluginManager::installPlugin($request->file('file'));

        return response()->json([
            'installed_at' => now()->format('Y-m-d H:i:s')
        ]);
    }

    public function destroy(DeleteRequest $request, $id)
    {
        \PluginManager::uninstallPlugin($id);

        return response()->noContent();
    }
}
