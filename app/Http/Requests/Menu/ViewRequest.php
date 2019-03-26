<?php

namespace App\Http\Requests\Menu;

use App\Http\Requests\BaseRequest;
use App\Model\Menu;
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
        $menu = Menu::find($this->route('menu'));

        if (!$menu) {
            throw new NotFoundHttpException('menu not found');
        }

        $this->attributes->add([
            'menu' => $menu
        ]);

        return $this->user()->can('view', $menu);
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
