<?php

namespace App\Http\Requests\Menu;

use App\Http\Requests\BaseRequest;
use App\Model\Menu;
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
        $menu = Menu::find($this->route('menu'));

        if (!$menu) {
            throw new NotFoundHttpException('menu not found');
        }

        $this->attributes->add([
            'menu' => $menu
        ]);

        return $this->user()->canAndOwns('menu-update-own', $menu, ['requireAll' => true]) || $this->user()->ability('superadmin', 'menu-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'menuItems' => 'required|array',
            'menuItems.*' => 'required|min:1',
            'menuItems.*.children' => 'array',
            'menuItems.*.type' => 'string'
        ];
    }
}
