<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\BaseRequest;
use App\Model\Post;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ViewRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $post = Post::with('author')->find($this->route('post'));

        if (!$post) {
            throw new NotFoundHttpException('post not found');
        }

        $this->attributes->add([
            'post' => $post
        ]);

        return $this->user()->can('view', $post);
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
