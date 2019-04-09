<?php

namespace App\Model;

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
            ['label' => 'Module', 'field' => 'module', 'width' => '20%'],
            ['label' => 'View', 'field' => 'abilities.view', 'width' => '20%', 'thClass' => 'text-center'],
            ['label' => 'Create', 'field' => 'abilities.create', 'width' => '20%', 'thClass' => 'text-center'],
            ['label' => 'Update', 'field' => 'abilities.update', 'width' => '20%', 'thClass' => 'text-center'],
            ['label' => 'Delete', 'field' => 'abilities.delete', 'width' => '20%', 'thClass' => 'text-center']
        ];
    }

    public static function displayDataOption()
    {
        return [
            [
                'module' => 'Page',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => true],
                    'create' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => true],
                    'delete' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => true]
                ]
            ],
            [
                'module' => 'Post',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => true],
                    'create' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => true],
                    'delete' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => true]
                ]
            ],
            [
                'module' => 'Form',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => true],
                    'create' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => true],
                    'delete' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => true]
                ]
            ],
            [
                'module' => 'User Manage',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false],
                    'create' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false],
                    'delete' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false]
                ]

            ],
            [
                'module' => 'General Setting',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false],
                ]
            ],
            [
                'module' => 'Acl Setting',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false],
                    'create' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false],
                    'update' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false],
                    'delete' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false]
                ]
            ],
            [
                'module' => 'Login Admin',
                'abilities' => [
                    'view' => ['state' => PermissionType::Disallow, 'label' => 'Disallow', 'has_own' => false]
                ]
            ]
        ];
    }
}
