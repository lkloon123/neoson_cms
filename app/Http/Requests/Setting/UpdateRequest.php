<?php

namespace App\Http\Requests\Setting;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('group') === 'public') {
            return true;
        }

        return $this->user()->ability('superadmin', $this->route('group') . '_setting-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data' => 'array|required'
        ];
    }
}
