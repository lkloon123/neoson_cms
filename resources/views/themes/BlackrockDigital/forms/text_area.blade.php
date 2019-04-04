<div class="form-group row">
    <div class="col-md-5 col-sm-12">
        <label for="{{ $id }}">{!! $label !!}</label>
        <textarea class="form-control {{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{ $name }}" id="{{ $id }}">{{ old($name) }}</textarea>
        @if ($errors->has($name))
            <div class="invalid-feedback">
                {{ $errors->first($name) }}
            </div>
        @endif
    </div>
</div>
