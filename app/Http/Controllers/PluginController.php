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
use App\Http\Requests\Plugin\ViewRequest;
use App\Http\Resources\PluginResource;
use App\Plugins\PluginManager;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class PluginController extends Controller
{
    public function index(ViewRequest $request, PluginManager $pluginManager)
    {
        return PluginResource::collection($pluginManager->getAllPlugin()->values());
    }

    public function update(UpdateRequest $request, $id, PluginManager $pluginManager)
    {
        $validated = $request->validated();

        if ($validated['isDisabled'] === true) {
            $result = $pluginManager->disablePlugin($pluginManager->getPlugin($id));
        } else {
            $result = $pluginManager->enablePlugin($pluginManager->getPlugin($id));
        }

        if (!$result) {
            throw new NotAcceptableHttpException('plugin is already ' . ($validated['isDisabled'] ? 'disabled' : 'enabled'));
        }

        return response()->json([
            'id' => $id,
            'updated_at' => now()->format('Y-m-d H:i:s')
        ]);
    }

    public function store(CreateRequest $request, PluginManager $pluginManager)
    {
        $pluginManager->installPlugin($request->file('file'));

        return response()->json([
            'installed_at' => now()->format('Y-m-d H:i:s')
        ]);
    }

    public function destroy(DeleteRequest $request, $id, PluginManager $pluginManager)
    {
        $pluginManager->uninstallPlugin($id);

        return response()->noContent();
    }
}
