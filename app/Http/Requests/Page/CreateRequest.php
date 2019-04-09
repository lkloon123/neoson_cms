<?php

namespace App\Http\Requests\Page;

use App\Http\Requests\BaseRequest;
use App\Model\Page;
use Illuminate\Validation\Rule;

class CreateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->ability('superadmin', 'page-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string',
            'description' => 'nullable|string',
            'publish_from_date' => 'required|date_format:Y-m-d H:i:s',
            'publish_to_date' => 'required|date_format:Y-m-d H:i:s|after_or_equal:publish_from_date',
            'slug' => 'required|string',
            'title' => 'required|string',
            'status' => ['required', Rule::in(['Draft', 'Publish'])]
        ];
    }
}
