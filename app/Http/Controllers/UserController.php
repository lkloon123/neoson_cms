<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/13/2019
 * Time: 11:25 AM.
 */

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\ViewRequest;
use App\Http\Resources\UserResource;
use App\Model\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public function index(ViewRequest $request)
    {
        if ($request->get('only_own')) {
            $users = Collection::wrap(
                User::with('roles:name')->find(\Auth::id())
            );
        } else {
            $users = User::with('roles:name')->get();
        }

        if ($users->isEmpty()) {
            return response()->noContent();
        }

        return UserResource::collection($users);
    }

    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();

        /** @var User $user */
        $user = $request->get('user');

        if ($validated['role']) {
            $user->syncRoles(Arr::wrap($validated['role']));
        }

        return response()->json([
            'id' => $user->id,
            'updated_at' => $user->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    public function getMe()
    {
        return new UserResource(\Auth::user());
    }

    public function count(ViewRequest $request)
    {
        return response()->json(User::count());
    }
}
