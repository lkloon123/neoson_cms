<?php

namespace App\Http\Requests\Post;

use App\Http\Requests\BaseRequest;
use App\Model\Post;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateRequest extends BaseRequest
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

        return $this->user()->canAndOwns('post-update-own', $post, ['requireAll' => true, 'foreignKeyName' => 'author_id']) || $this->user()->ability('superadmin', 'post-update');
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
            'tags' => 'array',
            'featuredImg' => 'nullable|string',
            'status' => ['required', Rule::in(['Draft', 'Publish'])]
        ];
    }
}
