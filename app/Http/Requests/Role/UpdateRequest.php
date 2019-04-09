<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\BaseRequest;
use App\Model\Role;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $role = Role::find($this->route('role'));

        if ($role === null || $role->name === 'superadmin') {
            throw new NotFoundHttpException('role not found');
        }

        $this->attributes->add([
            'role' => $role
        ]);

        return $this->user()->ability('superadmin', 'acl_setting-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'abilities' => 'required|array'
        ];
    }
}
