<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\BaseRequest;
use App\Model\Role;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ViewRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('role')) {
            $role = Role::with('permissions')->find($this->route('role'));

            if ($role === null || $role->name === 'superadmin') {
                throw new NotFoundHttpException('role not found');
            }

            $this->attributes->add([
                'role' => $role
            ]);
        }

        return $this->user()->ability('superadmin', 'acl_setting-view');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
