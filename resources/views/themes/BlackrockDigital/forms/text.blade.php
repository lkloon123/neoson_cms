<div class="form-group row">
    <div class="col-md-5 col-sm-12">
        <label for="{{ $id }}">
            {{ $label }}
            @if($validators->get('required'))
                <span style="color: #ff0000;">*</span>
            @endif
        </label>
        <input type="text" class="form-control {{ $errors->has($formKey) ? ' is-invalid' : '' }}" name="{{ $formKey }}" id="{{ $id }}" value="{{ old($formKey) }}"/>
        @if ($errors->has($formKey))
            <div class="invalid-feedback">
                {{ $errors->first($formKey) }}
            </div>
        @endif
    </div>
</div>
