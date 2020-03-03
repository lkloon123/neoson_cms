<?php

namespace App\Http\Controllers;

use App\Http\Requests\Menu\CreateRequest;
use App\Http\Requests\Menu\DeleteRequest;
use App\Http\Requests\Menu\UpdateRequest;
use App\Http\Requests\Menu\ViewRequest;
use App\Http\Resources\MenuItemsResource;
use App\Http\Resources\MenuResource;
use App\Model\Menu;

class MenuController extends Controller
{
    public function index(ViewRequest $request)
    {
        if ($request->get('only_own')) {
            $menus = \Auth::user()->menus()->get();
        } else {
            $menus = Menu::all();
        }

        if ($menus->isEmpty()) {
            return response()->noContent();
        }

        return MenuResource::collection($menus);
    }

    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        /** @var Menu $menu */
        $menu = \Auth::user()->menus()
            ->create([
                'name' => $validated['name']
            ]);

        $menu->insertMenuItem($validated['menuItems']);

        return response()->json([
            'id' => $menu->id,
            'created_at' => $menu->created_at->format('Y-m-d H:i:s')
        ]);
    }

    public function show(ViewRequest $request, $id)
    {
        return MenuItemsResource::collection($request->get('menu')->getTree())
            ->additional([
                'menu' => new MenuResource($request->get('menu'))
            ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();

        /** @var Menu $menu */
        $menu = $request->get('menu');
        $menu->update([
            'name' => $validated['name']
        ]);
        $menu->insertMenuItem($validated['menuItems']);

        //delete menu item
        $menu->menuItems()
            ->whereNotIn('meta_id', $menu->updatedMenuItemMetaId)
            ->delete();

        return response()->json([
            'id' => $menu->id,
            'updated_at' => $menu->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    public function destroy(DeleteRequest $request, $id)
    {
        /** @var Menu $menu */
        $menu = $request->get('menu');
        $result = $menu->delete();

        if (!$result) {
            throw new \Exception('Unable to delete page, please try again');
        }

        return response()->noContent();
    }
}
