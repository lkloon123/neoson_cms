<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Model\User;
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
        $user = User::find($this->route('user'));

        if (!$user) {
            throw new NotFoundHttpException('user not found');
        }

        $this->attributes->add([
            'user' => $user
        ]);

        return $this->user()->isAbleToAndOwns('user_manage-update-own', $user, ['requireAll' => true, 'foreignKeyName' => 'id']) || $this->user()->ability('superadmin', 'user_manage-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role' => 'string|exists:roles,name'
        ];
    }
}
