<?php

namespace App\Http\Resources;

/**
 * @mixin \App\Model\Language
 * */
class LanguageResource extends BaseResource
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
            'code' => $this->code,
            'title' => $this->title,
            'country_iso' => $this->country_iso,
            'count' => $this->when($this->translations_count !== null, $this->translations_count),
            $this->merge($this->dateTimeData())
        ];
    }
}
