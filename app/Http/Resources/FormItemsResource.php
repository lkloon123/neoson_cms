<?php

namespace App\Http\Resources;

/**
 * @mixin \App\Model\FormItem
 * */
class FormItemsResource extends BaseResource
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
            'id' => $this->meta_id,
            $this->merge($this->meta),
            'validators' => $this->validators,
        ];
    }
}
