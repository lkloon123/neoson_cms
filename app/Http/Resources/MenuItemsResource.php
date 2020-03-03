<?php

namespace App\Http\Resources;

use App\Model\Page;

/**
 * @mixin \App\Model\MenuItem
 * */
class MenuItemsResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $tmp = $this->meta;

        if ($tmp['type'] === 'page') {
            $page = Page::find($tmp['pageId']);
            $tmp['title'] = $page->title;
            $tmp['slug'] = $page->slug;
        }

        $tmp['id'] = $this->meta_id;
        $tmp['children'] = self::collection($this->whenLoaded('children'));
        return $tmp;
    }
}
