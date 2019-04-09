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
        if ($this->route('menu')) {
            $menu = Menu::find($this->route('menu'));

            if (!$menu) {
                throw new NotFoundHttpException('menu not found');
            }

            $this->attributes->add([
                'menu' => $menu
            ]);

            return $this->user()->canAndOwns('menu-view-own', $menu, ['requireAll' => true]) || $this->user()->ability('superadmin', 'menu-view');
        }

        if ($this->user()->can('menu-view-own')) {
            $this->attributes->add([
                'only_own' => true
            ]);
            return true;
        }

        return $this->user()->ability('superadmin', 'menu-view');
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
