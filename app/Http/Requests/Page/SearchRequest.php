<?php

namespace App\Http\Requests\Page;

use App\Http\Requests\BaseRequest;
use App\Model\Page;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SearchRequest extends ViewAllRequest
{
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
