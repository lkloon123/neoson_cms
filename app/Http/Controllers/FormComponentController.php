<?php

namespace App\Http\Controllers;

use App\Http\Resources\FormComponentResource;
use App\Model\FormComponent;
use Illuminate\Http\Request;

class FormComponentController extends Controller
{
    public function index()
    {
        return FormComponentResource::collection(FormComponent::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FormComponent  $formComponent
     * @return \Illuminate\Http\Response
     */
    public function show(FormComponent $formComponent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FormComponent  $formComponent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormComponent $formComponent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FormComponent  $formComponent
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormComponent $formComponent)
    {
        //
    }
}
