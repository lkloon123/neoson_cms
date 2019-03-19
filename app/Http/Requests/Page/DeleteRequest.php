<?php

namespace App\Http\Requests\Page;

use App\Http\Requests\BaseRequest;
use App\Model\Page;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $page = Page::find($this->route('page'));

        if (!$page) {
            throw new NotFoundHttpException('page not found');
        }

        $this->merge(['page' => $page]);

        return $this->user()->can('delete', $page);
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
