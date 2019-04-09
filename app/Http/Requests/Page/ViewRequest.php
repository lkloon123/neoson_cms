<?php

namespace App\Http\Requests\Page;

use App\Http\Requests\BaseRequest;
use App\Model\Page;
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
        if ($this->route('page')) {
            $page = Page::with('author')->find($this->route('page'));

            if (!$page) {
                throw new NotFoundHttpException('page not found');
            }

            $this->attributes->add([
                'page' => $page
            ]);

            return $this->user()->canAndOwns('page-view-own', $page, ['requireAll' => true, 'foreignKeyName' => 'author_id']) || $this->user()->ability('superadmin', 'page-view');
        }

        if ($this->user()->can('page-view-own')) {
            $this->attributes->add([
                'only_own' => true
            ]);
            return true;
        }

        return $this->user()->ability('superadmin', 'page-view');
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
