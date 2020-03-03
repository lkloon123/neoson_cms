<?php

namespace App\Http\Resources;

/**
 * @mixin \App\Model\Form
 * */
class FormResource extends BaseResource
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
            'responses' => $this->form_responses_count,
            $this->merge($this->dateTimeData())
        ];
    }
}
