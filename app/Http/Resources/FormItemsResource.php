<?php

namespace App\Http\Resources;

use App\Model\Page;

/**
 * @mixin \App\Model\FormItem
 * */
class FormItemsResource extends BaseResource
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
        return $tmp;
    }
}
