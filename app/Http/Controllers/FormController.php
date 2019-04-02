<?php

namespace App\Http\Controllers;

use App\Http\Requests\Form\CreateRequest;
use App\Http\Requests\Form\DeleteRequest;
use App\Http\Requests\Form\UpdateRequest;
use App\Http\Requests\Form\ViewAllRequest;
use App\Http\Requests\Form\ViewRequest;
use App\Http\Resources\FormItemsResource;
use App\Http\Resources\FormResource;
use App\Model\Form;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ViewAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ViewAllRequest $request)
    {
        if (\Auth::user()->isAn('superadmin', 'admin')) {
            $forms = Form::all();
        } else {
            $forms = \Auth::user()->forms()->get();
        }

        if ($forms->isEmpty()) {
            return response()->json([], 204);
        }

        return FormResource::collection($forms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        /** @var Form $form */
        $form = \Auth::user()->forms()
            ->create([
                'name' => $validated['name']
            ]);

        $form->insertFormItem($validated['formItems']);

        //reset updatedFormItem
        $form->updatedFormItemMetaId = [];

        return response()->json([
            'id' => $form->id,
            'created_at' => $form->created_at->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param ViewRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
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

        //reset updatedFormItem
        $form->updatedFormItemMetaId = [];

        return response()->json([
            'id' => $form->id,
            'updated_at' => $form->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteRequest $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DeleteRequest $request, $id)
    {
        /** @var Form $form */
        $form = $request->get('form');
        $result = $form->delete();

        if (!$result) {
            throw new \Exception('Unable to delete page, please try again');
        }

        return response()->json([], 204);
    }
}
