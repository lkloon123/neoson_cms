<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\BaseRequest;
use App\Model\Form;
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
        $form = Form::find($this->route('form'));

        if (!$form) {
            throw new NotFoundHttpException('form not found');
        }

        $this->attributes->add([
            'form' => $form
        ]);

        return $this->user()->isAbleToAndOwns('form-update-own', $form, ['requireAll' => true]) || $this->user()->ability('superadmin', 'form-update');
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
            'formItems' => 'required|array',
        ];
    }
}
