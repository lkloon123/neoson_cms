<?php

namespace App\Model;

use App\Enums\HookActions;
use App\Enums\PermissionType;
use Laratrust\Models\LaratrustPermission;

/**
 * App\Model\Permission
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $module
 * @property-read mixed $type
 * @property-read mixed $only_own
 * @property-read int|null $roles_count
 */
class Permission extends LaratrustPermission
{
    protected $guarded = ['id'];

    public function getModuleAttribute()
    {
        return explode('-', $this->name)[0];
    }

    public function getTypeAttribute()
    {
        return explode('-', $this->name)[1];
    }

    public function getOnlyOwnAttribute()
    {
        $onlyOwn = explode('-', $this->name);
        if ((substr_count($this->name, '-') + 1) > 2) {
            return $onlyOwn[2] === 'own';
        }

        return false;
    }

    public static function displayColumnsOption()
    {
        return [
            ['label' => 'role.module', 'field' => 'module', 'width' => '20%'],
            ['label' => 'common.view', 'field' => 'abilities.view', 'width' => '20%', 'thClass' => 'text-center'],
            ['label' => 'common.create', 'field' => 'abilities.create', 'width' => '20%', 'thClass' => 'text-center'],
            ['label' => 'common.update', 'field' => 'abilities.update', 'width' => '20%', 'thClass' => 'text-center'],
            ['label' => 'common.delete', 'field' => 'abilities.delete', 'width' => '20%', 'thClass' => 'text-center']
        ];
    }

    public static function displayDataOption()
    {
        $default = [
            [
                'module' => 'menu.pages',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'has_own' => true],
                    'create' => ['state' => PermissionType::Disallow, 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'has_own' => true],
                    'delete' => ['state' => PermissionType::Disallow, 'has_own' => true]
                ]
            ],
            [
                'module' => 'menu.posts',
                'abilities' => [
                    'view' => ['state' => PermissionType::OnlyOwn, 'has_own' => true],
                    'create' => ['state' => PermissionType::Allow, 'has_own' => false],
                    'update' => ['state' => PermissionType::OnlyOwn, 'has_own' => true],
                    'delete' => ['state' => PermissionType::OnlyOwn, 'has_own' => true]
                ]
            ],
            [
                'module' => 'menu.forms',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'has_own' => true],
                    'create' => ['state' => PermissionType::Disallow, 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'has_own' => true],
                    'delete' => ['state' => PermissionType::Disallow, 'has_own' => true]
                ]
            ],
            [
                'module' => 'setting.user_management',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'has_own' => true],
                    'create' => ['state' => PermissionType::Disallow, 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'has_own' => true],
                    'delete' => ['state' => PermissionType::Disallow, 'has_own' => false]
                ]

            ],
            [
                'module' => 'menu.plugins',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'has_own' => false],
                    'create' => ['state' => PermissionType::Disallow, 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'has_own' => false],
                    'delete' => ['state' => PermissionType::Disallow, 'has_own' => false]
                ]
            ],
            [
                'module' => 'setting.translation',
                'abilities' => [
                    'create' => ['state' => PermissionType::Disallow, 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'has_own' => false]
                ]
            ],
            [
                'module' => 'setting.general_settings',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'has_own' => false],
                ]
            ],
            [
                'module' => 'setting.integration_settings',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'has_own' => false],
                ]
            ],
            [
                'module' => 'setting.roles_and_permission',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'has_own' => false],
                    'create' => ['state' => PermissionType::Disallow, 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'has_own' => false],
                    'delete' => ['state' => PermissionType::Disallow, 'has_own' => false]
                ]
            ],
            [
                'module' => 'common.login_admin',
                'abilities' => [
                    'view' => ['state' => PermissionType::Allow, 'has_own' => false]
                ]
            ],
            [
                'module' => 'Telescope',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'has_own' => false]
                ]
            ]
        ];

        $default = \HookManager::applyFilter(HookActions::PermissionFilter, $default);
        return $default;
    }
}
