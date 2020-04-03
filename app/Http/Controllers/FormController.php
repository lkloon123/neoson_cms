<?php

namespace App\Http\Controllers;

use App\Http\Requests\Form\CreateRequest;
use App\Http\Requests\Form\DeleteRequest;
use App\Http\Requests\Form\FormSubmitRequest;
use App\Http\Requests\Form\UpdateRequest;
use App\Http\Requests\Form\ViewFormResponseRequest;
use App\Http\Requests\Form\ViewRequest;
use App\Http\Resources\FormItemsResource;
use App\Http\Resources\FormResource;
use App\Http\Resources\FormResponsesResource;
use App\Model\Form;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function index(ViewRequest $request)
    {
        if ($request->get('only_own')) {
            $forms = $this->getUser()->forms()->withCount('formResponses')->get();
        } else {
            $forms = Form::withCount('formResponses')->get();
        }

        if ($forms->isEmpty()) {
            return response()->noContent();
        }

        return FormResource::collection($forms);
    }

    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        /** @var Form $form */
        $form = $this->getUser()->forms()
            ->create([
                'name' => $validated['name']
            ]);

        $form->insertFormItem($validated['formItems']);

        return response()->json([
            'id' => $form->id,
            'created_at' => $form->created_at->format('Y-m-d H:i:s')
        ]);
    }

    public function show(ViewRequest $request, $id)
    {
        $formItems = $request->get('form')
            ->formItems()
            ->orderBy('display_order')
            ->get();

        return FormItemsResource::collection($formItems)
            ->additional([
                'form' => new FormResource($request->get('form'))
            ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();

        /** @var Form $form */
        $form = $request->get('form');
        $form->update([
            'name' => $validated['name']
        ]);
        $form->insertFormItem($validated['formItems']);

        //delete form item
        $form->formItems()
            ->whereNotIn('meta_id', $form->updatedFormItemMetaId)
            ->delete();

        return response()->json([
            'id' => $form->id,
            'updated_at' => $form->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    public function destroy(DeleteRequest $request, $id)
    {
        /** @var Form $form */
        $form = $request->get('form');
        $result = $form->delete();

        if (!$result) {
            throw new \Exception('Unable to delete page, please try again');
        }

        return response()->noContent();
    }

    public function formSubmit(FormSubmitRequest $request)
    {
        $validated = Arr::except($request->validated(), 'formId');

        /** @var Form $form */
        $form = $request->get('form');
        $form->formResponses()->create([
            'meta' => $validated
        ]);

        \Session::flash('flash-message', 'The form data has been recorded');
        return back();
    }

    public function formResponse(ViewFormResponseRequest $request, $id)
    {
        /** @var Form $form */
        $form = $request->get('form');

        if ($form->formResponses->isEmpty()) {
            return response()->noContent();
        }

        $lastResponse = $form->formResponses->first();

        return FormResponsesResource::collection($form->formResponses)
            ->additional(array_merge(
                $lastResponse->buildColumns(),
                ['form_name' => Str::title(str_replace('_', ' ', $form->name))]
            ));
    }
}
