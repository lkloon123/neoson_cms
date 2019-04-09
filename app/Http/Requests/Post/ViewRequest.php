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
        if ($this->route('post')) {
            $post = Post::with('author')->find($this->route('post'));

            if (!$post) {
                throw new NotFoundHttpException('post not found');
            }

            $this->attributes->add([
                'post' => $post
            ]);

            return $this->user()->canAndOwns('post-view-own', $post, ['requireAll' => true, 'foreignKeyName' => 'author_id']) || $this->user()->ability('superadmin', 'post-view');
        }

        if ($this->user()->can('post-view-own')) {
            $this->attributes->add([
                'only_own' => true
            ]);
            return true;
        }

        return $this->user()->ability('superadmin', 'post-view');
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
