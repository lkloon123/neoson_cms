<?php

namespace App\Http\Resources;

use App\Model\Role;

/**
 * @mixin Role
 * */
class RoleResource extends BaseResource
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
            'title' => $this->display_name,
            'users_count' => $this->users_count,
            'abilities' => PermissionResource::collection($this->whenLoaded('permissions')),
            $this->merge($this->dateTimeData())
        ];
    }
}
