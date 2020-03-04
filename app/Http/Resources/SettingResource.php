<?php

namespace App\Http\Resources;

use App\Model\Setting;

/**
 * @mixin Setting
 * */
class SettingResource extends BaseResource
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
            'setting_key' => $this->setting_key,
            'setting_value' => $this->setting_value,
            'config_key' => $this->when($this->config_key, $this->config_key),
            'type' => $this->type,
            'group' => $this->group,
            'meta' => $this->meta,
            $this->merge($this->dateTimeData())
        ];
    }
}
