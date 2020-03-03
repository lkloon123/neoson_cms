<?php

use Illuminate\Database\Seeder;

class FormComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\FormComponent::create([
            'default_meta' => [
                'type' => 'text',
                'label' => 'Text',
                'componentLabel' => 'Text',
                'validators' => ['required' => false],
            ],
            'html_component' => '<label>
    {{field.label}}
    <span v-if="field.validators.required" class="text-danger ml-1">*</span>
</label>
<input class="form-control" type="text" readonly/>'
        ]);

        \App\Model\FormComponent::create([
            'default_meta' => [
                'type' => 'text_area',
                'label' => 'Text Area',
                'componentLabel' => 'Text Area',
                'validators' => ['required' => false],
            ],
            'html_component' => '<label>
    {{field.label}}
    <span v-if="field.validators.required" class="text-danger ml-1">*</span>
</label>
<textarea class="form-control" readonly></textarea>'
        ]);

        \App\Model\FormComponent::create([
            'default_meta' => [
                'type' => 'submit_button',
                'label' => 'Submit',
                'componentLabel' => 'Submit',
            ],
            'html_component' => '<button type="submit" class="btn btn-primary">{{field.label}}</button>'
        ]);
    }
}
