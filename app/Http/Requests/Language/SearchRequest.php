<?php

namespace App\Http\Requests\Language;

use App\Http\Requests\BaseRequest;

class SearchRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string'
        ];
    }
}
