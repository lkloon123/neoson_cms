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
                'readonly' => true,
                'validators' => ['required' => false],
            ],
            'html_component' => '<label>
    {{field.label}}
    <span v-if="field.validators.required" class="text-danger ml-1">*</span>
</label>
<input class="form-control" type="text" :readonly="field.readonly" :value="field.value" @input="field.inputWatcher"/>
<small class="form-text text-muted" v-if="field.description">{{field.description}}</small>'
        ]);

        \App\Model\FormComponent::create([
            'default_meta' => [
                'type' => 'text_area',
                'label' => 'Text Area',
                'componentLabel' => 'Text Area',
                'readonly' => true,
                'validators' => ['required' => false],
            ],
            'html_component' => '<label>
    {{field.label}}
    <span v-if="field.validators.required" class="text-danger ml-1">*</span>
</label>
<textarea class="form-control" :readonly="field.readonly" :value="field.value" @input="field.inputWatcher"></textarea>
<small class="form-text text-muted" v-if="field.description">{{field.description}}</small>'
        ]);

        \App\Model\FormComponent::create([
            'default_meta' => [
                'type' => 'password',
                'label' => 'Password',
                'componentLabel' => 'Password',
                'readonly' => true,
                'validators' => ['required' => false],
            ],
            'html_component' => '<label>
    {{field.label}}
    <span v-if="field.validators.required" class="text-danger ml-1">*</span>
</label>
<input class="form-control" type="password" :readonly="field.readonly" :value="field.value" @input="field.inputWatcher"/>
<small class="form-text text-muted" v-if="field.description">{{field.description}}</small>'
        ]);

        \App\Model\FormComponent::create([
            'default_meta' => [
                'type' => 'submit_button',
                'label' => 'Submit',
                'componentLabel' => 'Submit',
            ],
            'html_component' => '<button type="submit" class="btn btn-primary" @click="field.submitWatcher">{{field.label}}</button>'
        ]);
    }
}
