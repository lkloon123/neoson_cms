<form id="{{ $formName }}" method="POST" action="/form-submit{{ "#$formName" }}">
    {!! PageContent::block('FlashMessage') !!}
    @csrf
    <input type="hidden" name="formId" value="{{ $formId }}">
    {!! $formElements !!}
</form>
