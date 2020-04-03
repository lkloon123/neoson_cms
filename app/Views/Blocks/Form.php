<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/3/2019
 * Time: 4:13 PM.
 */

namespace App\Views\Blocks;

use App\Model\Form as FormModel;
use App\Views\AbstractClass\AbstractBlock;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Form extends AbstractBlock
{
    public function display()
    {
        $form = $this->getForm();
        if (!$form) {
            return 'Form not found';
        }

        return $this->buildFormElement($form);
    }

    protected function buildFormElement(FormModel $form)
    {
        $formElements = '';

        foreach ($form->formItems as $formItem) {
            $formElements .= $this->renderView('.forms.' . $formItem->type, [
                'label' => $formItem->label,
                'id' => $formItem->meta_id,
                'formKey' => $formItem->formKey,
                'meta' => $formItem->meta,
                'validators' => $formItem->validators,
            ]);
        }

        return \View::make('formWrapper', [
            'formElements' => $formElements,
            'formId' => \Crypt::encrypt($form->id),
            'formName' => Str::kebab($form->name)
        ]);
    }

    protected function getForm()
    {
        $form = FormModel::whereName($this->getFormName())
            ->with([
                'formItems' => function (HasMany $query) {
                    $query->orderBy('display_order');
                }
            ])
            ->first();

        return $form;
    }

    protected function getFormName()
    {
        return $this->additionalData->get('name');
    }
}
