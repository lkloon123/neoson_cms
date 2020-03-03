<?php

namespace App\Model;

use Illuminate\Support\Arr;

/**
 * App\Model\Menu
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\MenuItem[] $menuItems
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu whereUserId($value)
 * @mixin \Eloquent
 * @property-read int|null $audits_count
 * @property-read int|null $menu_items_count
 */
class Menu extends BaseModel
{
    protected $softCascade = ['menuItems'];
    public $updatedMenuItemMetaId = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function insertMenuItem($items, $parentId = 0)
    {
        $displayOrder = 1;
        foreach ($items as $item) {
            //insert the object
            $menuItem = $this->menuItems()->updateOrCreate(
                ['meta_id' => $item['id']],
                [
                    'parent_id' => $parentId,
                    'display_order' => $displayOrder,
                    'meta_id' => $item['id'],
                    'meta' => Arr::except($item, ['id', 'children']),
                ]
            );

            $this->updatedMenuItemMetaId[] = $menuItem->meta_id;

            if ($item['children'] && \count($item['children']) > 0) {
                //this object has children
                $this->insertMenuItem($item['children'], $menuItem->id);
            }

            ++$displayOrder;
        }
    }

    public function getTree()
    {
        return $this->menuItems()->with(implode('.', array_fill(0, 10, 'children')))
            ->where('parent_id', '=', '0')
            ->orderBy('display_order')
            ->get();
    }
}
