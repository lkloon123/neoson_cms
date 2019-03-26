<?php

namespace App\Http\Controllers;

use App\Http\Requests\Menu\CreateRequest;
use App\Http\Requests\Menu\DeleteRequest;
use App\Http\Requests\Menu\UpdateRequest;
use App\Http\Requests\Menu\ViewAllRequest;
use App\Http\Requests\Menu\ViewRequest;
use App\Http\Resources\MenuItemsResource;
use App\Http\Resources\MenuResource;
use App\Model\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ViewAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ViewAllRequest $request)
    {
        if (\Auth::user()->isAn('superadmin', 'admin')) {
            $menus = Menu::all();
        } else {
            $menus = \Auth::user()->menus()->get();
        }

        if ($menus->isEmpty()) {
            return response()->json([], 204);
        }

        return MenuResource::collection($menus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Display the specified resource.
     *
     * @param ViewRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(ViewRequest $request, $id)
    {
        return MenuItemsResource::collection($request->get('menu')->getTree())
            ->additional([
                'menu' => new MenuResource($request->get('menu'))
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();

        /** @var Menu $menu */
        $menu = $request->get('menu');
        $menu->update([
            'name' => $validated['name']
        ]);
        $menu->insertMenuItem($validated['menuItems']);

        return response()->json([
            'id' => $menu->id,
            'updated_at' => $menu->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteRequest $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DeleteRequest $request, $id)
    {
        /** @var Menu $menu */
        $menu = $request->get('menu');
        $result = $menu->delete();

        if (!$result) {
            throw new \Exception('Unable to delete page, please try again');
        }

        return response()->json([], 204);
    }
}
