<?php

namespace App\Http\Resources;

use App\Model\Page;

/**
 * @mixin \App\Model\FormResponse
 * */
class FormResponsesResource extends BaseResource
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
        $tmp['id'] = $this->id;
        return array_merge($tmp, $this->dateTimeData());
    }
}
