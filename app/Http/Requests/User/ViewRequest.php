<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Model\User;
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
        if ($this->route('user')) {
            $user = User::find($this->route('user'));

            if (!$user) {
                throw new NotFoundHttpException('user not found');
            }

            $this->attributes->add([
                'user' => $user
            ]);

            return $this->user()->canAndOwns('user_manage-view-own', $user, ['requireAll' => true, 'foreignKeyName' => 'id']) || $this->user()->ability('superadmin', 'user_manage-view');
        }

        if ($this->user()->can('user_manage-view-own')) {
            $this->attributes->add([
                'only_own' => true
            ]);
            return true;
        }

        return $this->user()->ability('superadmin', 'user_manage-view');
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
