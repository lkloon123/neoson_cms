<?php

namespace App\Http\Requests\Form;

use App\Http\Requests\BaseRequest;
use App\Model\Form;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ViewFormResponseRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $form = Form::with([
            'formResponses' => function (HasMany $query) {
                return $query->orderBy('created_at', 'desc');
            }
        ])->find($this->route('form'));

        if (!$form) {
            throw new NotFoundHttpException('form not found');
        }

        $this->attributes->add([
            'form' => $form
        ]);

        return $this->user()->can('view', $form);
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
