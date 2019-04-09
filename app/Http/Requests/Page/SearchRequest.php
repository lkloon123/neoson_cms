<?php

namespace App\Http\Requests\Page;

class SearchRequest extends ViewRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string',
            'include' => 'string|integer'
        ];
    }
}
