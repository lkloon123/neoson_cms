<?php

namespace App\Http\Resources;

/**
 * @mixin \App\Model\MenuItem
 * */
class MenuItemsResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $tmp = $this->meta;
        $tmp['id'] = $this->meta_id;
        $tmp['children'] = self::collection($this->whenLoaded('children'));
        return $tmp;
    }
}
