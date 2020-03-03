<?php

namespace App\Http\Resources;

/**
 * @mixin \App\Model\FormComponent
 * */
class FormComponentResource extends BaseResource
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
            'html_component' => $this->html_component,
            'default_meta' => $this->default_meta,
            $this->merge($this->dateTimeData())
        ];
    }
}
