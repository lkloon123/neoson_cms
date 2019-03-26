<?php

namespace App\Model;

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
