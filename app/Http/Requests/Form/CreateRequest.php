<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\BaseRequest;
use App\Model\Form;

class CreateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Form::class);
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
            'formItems' => 'required|array',
        ];
    }
}
