<template>
    <div class="form-group row align-items-center">
        <label class="form-control-label col-md-3" :for="getId">{{form.label}}</label>
        <div class="col-md-9">
            <text-form :form="form"
                       :value="value"
                       @input="$emit('input', $event)"
                       v-if="form.type === 'text'"></text-form>
            <password-form :form="form"
                           :value="value"
                           @input="$emit('input', $event)"
                           v-else-if="form.type === 'password'"></password-form>
            <checkbox-form :form="form"
                           :value="value"
                           @input="$emit('input', $event)"
                           v-else-if="form.type === 'checkbox'"></checkbox-form>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <small :id="getId" class="form-text text-muted" v-if="form.desc">{{form.desc}}</small>
        </div>
    </div>
</template>

<script>
    import TextForm from './TextForm';
    import CheckboxForm from './CheckboxForm';
    import PasswordForm from './PasswordForm';
    import Mixin from './mixin';

    export default {
        mixins: [Mixin],
        components: {
            TextForm, CheckboxForm, PasswordForm
        }
    }
</script>

<style scoped>

</style>
