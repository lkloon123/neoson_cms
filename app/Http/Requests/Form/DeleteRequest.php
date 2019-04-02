<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\BaseRequest;
use App\Model\Form;
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
        $form = Form::find($this->route('form'));

        if (!$form) {
            throw new NotFoundHttpException('form not found');
        }

        $this->attributes->add([
            'form' => $form
        ]);

        return $this->user()->can('delete', $form);
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
