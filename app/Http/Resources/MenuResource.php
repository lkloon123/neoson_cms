<?php

namespace App\Http\Resources;

/**
 * @mixin \App\Model\Menu
 * */
class MenuResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name
        ], $this->dateTimeData());
    }
}
