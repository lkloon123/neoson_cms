<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/5/2019
 * Time: 3:17 PM.
 */

namespace App\Http\Controllers;


use App\Http\Requests\Role\CreateRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Http\Requests\Role\ViewRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Model\Permission;
use App\Model\Role;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index(ViewRequest $request)
    {
        $roles = Role::where('name', '!=', 'superadmin')->get();

        if ($roles->isEmpty()) {
            return response()->json([], 204);
        }

        return RoleResource::collection($roles);
    }

    public function show(ViewRequest $request, $id)
    {
        return new RoleResource($request->get('role'));
    }

    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        $role = Role::create([
            'name' => strtolower(Str::snake($validated['name'])),
            'display_name' => ucwords($validated['name'])
        ]);

        $abilities = collect($validated['abilities'])->recursive();
        $role->savePermission($abilities);

        return response()->json([
            'id' => $role->id,
            'created_at' => $role->created_at->format('Y-m-d H:i:s')
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();

        /** @var Role $role */
        $role = $request->get('role');
        $role->update([
            'name' => strtolower(Str::snake($validated['name'])),
            'display_name' => ucwords($validated['name'])
        ]);

        $abilities = collect($validated['abilities'])->recursive();
        $role->savePermission($abilities);

        return response()->json([
            'id' => $role->id,
            'updated_at' => $role->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    public function getPermissions()
    {
        return [
            'role' => \Auth::user()->roles->first()->name,
            'permissions' => PermissionResource::collection(\Auth::user()->allPermissions())
        ];
    }

    public function abilities()
    {
        return [
            'columns' => Permission::displayColumnsOption(),
            'data' => Permission::displayDataOption()
        ];
    }

    public function getRolesOptions(ViewRequest $request)
    {
        return Role::all(['id', 'name']);
    }
}
