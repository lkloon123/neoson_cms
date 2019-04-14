<?php

namespace App\Http\Resources;


/**
 * @mixin \App\Model\Tag
 * */
class TagResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->when($this->slug, $this->slug),
            'count' => $this->when($this->count !== null, $this->count)
        ];
    }
}
