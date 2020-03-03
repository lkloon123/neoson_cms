<?php

namespace App\Http\Resources;

/**
 * @mixin \App\Model\User
 * */
class UserResource extends BaseResource
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
            'email' => $this->email,
            'role' => $this->when($this->relationLoaded('roles'), $this->roles->first()->name),
            'last_login_at' => $this->last_login_at !== null ? $this->last_login_at->format('Y-m-d H:i:s') : null,
            'last_login_ip' => $this->when(\Auth::user()->isA('superadmin'), $this->last_login_ip),
            'last_logout_at' => $this->last_logout_at !== null ? $this->last_logout_at->format('Y-m-d H:i:s') : null,
            $this->merge($this->dateTimeData())
        ];
    }
}
