<?php

namespace App\Http\Resources;

use App\Model\Permission;

/**
 * @mixin Permission
 * */
class PermissionResource extends BaseResource
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
            'module' => $this->module,
            'name' => $this->type,
            'only_own' => $this->only_own
        ];
    }
}
