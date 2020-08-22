<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\BaseRequest;
use App\Model\Post;
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
        $post = Post::find($this->route('post'));

        if (!$post) {
            throw new NotFoundHttpException('post not found');
        }

        $this->attributes->add([
            'post' => $post
        ]);

        return $this->user()->isAbleToAndOwns('post-delete-own', $post, ['requireAll' => true, 'foreignKeyName' => 'author_id']) || $this->user()->ability('superadmin', 'post-delete');
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
