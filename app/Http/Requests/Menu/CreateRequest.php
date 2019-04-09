<?php

namespace App\Http\Requests\Menu;

use App\Http\Requests\BaseRequest;
use App\Model\Menu;

class CreateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->ability('superadmin', 'menu-create');
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
            'menuItems' => 'required|array',
            'menuItems.*' => 'required|min:1',
            'menuItems.*.children' => 'array',
            'menuItems.*.type' => 'string'
        ];
    }
}
