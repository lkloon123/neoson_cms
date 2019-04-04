<div class="form-group row">
    <div class="col-md-5 col-sm-12">
        <label for="{{ $id }}">{!! $label !!}</label>
        <input type="text" class="form-control {{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{ $name }}" id="{{ $id }}" value="{{ old($name) }}"/>
        @if ($errors->has($name))
            <div class="invalid-feedback">
                {{ $errors->first($name) }}
            </div>
        @endif
    </div>
</div>
