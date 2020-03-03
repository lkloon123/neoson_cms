<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\BaseRequest;
use App\Model\Form;
use App\Model\FormItem;
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
        $defaultValidator = ['formId' => 'required'];

        return array_merge($this->getFormValidators(), $defaultValidator);
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

            $rules = [];

            /** @var FormItem $formItem */
            foreach ($form->formItems as $formItem) {
                if (strpos($formItem->type, 'button') !== false) {
                    continue;
                }

                $currentElementValidator = [];
                if ($validators = $formItem->validators) {
                    foreach ($validators as $validatorRule => $validatorValue) {
                        if ($validatorValue) {
                            $currentElementValidator[] = $validatorRule;
                        }
                    }
                }

                $rules[$formItem->name] = implode('|', $currentElementValidator);
            }

            $this->attributes->add([
                'form' => $form
            ]);

            return $rules;
        }

        throw new BadRequestHttpException('Unable to find form id');
    }
}
