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

        $this->attributes->add([
            'page' => $page
        ]);

        return $this->user()->canAndOwns('page-delete-own', $page, ['requireAll' => true, 'foreignKeyName' => 'author_id']) || $this->user()->ability('superadmin', 'page-delete');
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
