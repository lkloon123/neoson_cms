<?php

namespace App\Model;

use App\Enums\PermissionType;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laratrust\Models\LaratrustRole;

/**
 * App\Model\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Permission[] $permissions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\User[] $users
 */
class Role extends LaratrustRole
{
    protected $guarded = ['id'];

    public function savePermission($abilities)
    {
        $allPermissions = [];

        foreach ($abilities as $ability) {
            /** @var Collection $ability */
            $ability->get('abilities')->map(function ($item, $key) use ($ability, &$allPermissions) {
                if ($item->get('state') === PermissionType::Allow) {
                    $permission = Permission::firstOrCreate(
                        ['name' => Str::snake(strtolower($ability->get('module')) . '-' . $key)],
                        [
                            'name' => Str::snake(strtolower($ability->get('module')) . '-' . $key),
                            'display_name' => ucfirst($key) . ' ' . ucfirst($ability->get('module'))
                        ]
                    );
                    $allPermissions[] = $permission;
                } else if ($item->get('state') === PermissionType::OnlyOwn) {
                    $permission = Permission::firstOrCreate(
                        ['name' => Str::snake(strtolower($ability->get('module')) . '-' . $key . '-own')],
                        [
                            'name' => Str::snake(strtolower($ability->get('module')) . '-' . $key . '-own'),
                            'display_name' => ucfirst($key) . ' Own ' . ucfirst($ability->get('module'))
                        ]
                    );
                    $allPermissions[] = $permission;
                }
            });
        }

        $this->syncPermissions($allPermissions);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
