<?php

namespace App\Model;

/**
 * App\Model\MenuItem
 *
 * @property int $id
 * @property int $menu_id
 * @property int $parent_id
 * @property int $display_order
 * @property string $meta_id
 * @property array $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\MenuItem[] $children
 * @property-read \App\Model\Menu $menu
 * @property-read \App\Model\MenuItem $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MenuItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MenuItem extends BaseModel
{
    protected $casts = [
        'meta' => 'array'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->hasOne(__CLASS__, 'id', 'parent_id')->orderBy('display_order');
    }

    public function children()
    {
        return $this->hasMany(__CLASS__, 'parent_id', 'id')->orderBy('display_order');
    }
}
