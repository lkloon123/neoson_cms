<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/30/2019
 * Time: 4:46 PM.
 */

namespace App\Http\Resources;


class PluginResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $pluginInformation = collect($this->pluginInformation());
        return [
            'isDisabled' => $this->isDisabled,
            'id' => $this->id,
            'name' => $pluginInformation->get('name'),
            'ver' => $pluginInformation->get('ver'),
            'desc' => $this->when($pluginInformation->has('desc'), $pluginInformation->get('desc')),
            'author' => $this->when($pluginInformation->has('author'), $pluginInformation->get('author'))
        ];
    }
}
