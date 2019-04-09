<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\BaseRequest;
use App\Model\Form;
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
        if ($this->route('form')) {
            $form = Form::find($this->route('form'));

            if (!$form) {
                throw new NotFoundHttpException('form not found');
            }

            $this->attributes->add([
                'form' => $form
            ]);

            return $this->user()->canAndOwns('form-view-own', $form, ['requireAll' => true]) || $this->user()->ability('superadmin', 'form-view');
        }

        if ($this->user()->can('form-view-own')) {
            $this->attributes->add([
                'only_own' => true
            ]);
            return true;
        }

        return $this->user()->ability('superadmin', 'form-view');
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
