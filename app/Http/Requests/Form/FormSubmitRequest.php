<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\BaseRequest;
use App\Model\Form;
use App\Model\FormItem;
use Illuminate\Contracts\Encryption\DecryptException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FormSubmitRequest extends BaseRequest
{
    protected $errorMessages = [];

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

    public function messages()
    {
        return $this->errorMessages;
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
                        if ($validatorValue !== false) {
                            if (class_exists($validatorRule)) {
                                $validatorRule = new $validatorRule();
                            } else {
                                //set error message if value is string
                                if (is_string($validatorValue)) {
                                    $this->errorMessages[$formItem->formKey . '.' . $validatorRule] = $validatorValue;
                                }
                            }

                            $currentElementValidator[] = $validatorRule;
                        }
                    }
                }

                $rules[$formItem->formKey] = $currentElementValidator;
            }

            $this->attributes->add([
                'form' => $form
            ]);

            return $rules;
        }

        throw new BadRequestHttpException('Unable to find form id');
    }
}
