<?php

namespace App\Http\Resources;

use App\Enums\PageStatus;

/**
 * @mixin \App\Model\Page
 * */
class PageResource extends BaseResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description ?? '',
            'content' => $this->content,
            'author' => new UserResource($this->whenLoaded('author')),
            'status' => PageStatus::getKey($this->status),
            'publish_from_date' => $this->start_at !== null ? $this->start_at->format('Y-m-d H:i:s') : null,
            'publish_to_date' => $this->expired_at !== null ? $this->expired_at->format('Y-m-d H:i:s') : null
        ], $this->dateTimeData());
    }
}
