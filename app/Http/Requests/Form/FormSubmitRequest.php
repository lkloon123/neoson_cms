<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\BaseRequest;
use App\Model\Form;
use Illuminate\Contracts\Encryption\DecryptException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FormSubmitRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($formValidators = $this->getFormValidators()) {
            return array_merge([
                'formId' => 'required'
            ], $formValidators);
        }

        return [
            'formId' => 'required'
        ];
    }

    protected function getFormValidators()
    {
        if ($encryptedFormId = $this->get('formId')) {
            try {
                $form = Form::with('formItems')
                    ->find(\Crypt::decrypt($encryptedFormId));
            } catch (DecryptException $e) {
                throw new BadRequestHttpException('Unable to find form id');
            }

            if (!$form) {
                throw new BadRequestHttpException('Unable to find form id');
            }

            $validators = [];

            foreach ($form->formItems as $formItem) {
                if (strpos($formItem->type, 'button') !== false) {
                    continue;
                }

                $currentElementValidator = [];
                if ($formItem->is_required) {
                    $currentElementValidator[] = 'required';
                }

                $validators[$formItem->name] = implode('|', $currentElementValidator);
            }

            $this->attributes->add([
                'form' => $form
            ]);

            return $validators;
        }

        return false;
    }
}
