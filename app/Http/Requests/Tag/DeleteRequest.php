<?php

namespace App\Http\Requests\Tag;

use App\Http\Requests\BaseRequest;
use App\Model\Tag;
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
        $tag = Tag::find($this->route('tag'));

        if (!$tag) {
            throw new NotFoundHttpException('tag not found');
        }

        $this->attributes->add([
            'tag' => $tag
        ]);

        return $this->user()->ability('superadmin', ['post-delete', 'post-delete-own']);
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
