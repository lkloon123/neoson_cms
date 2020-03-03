<template>
  <div class="form-group row align-items-center">
    <label
      class="form-control-label col-md-3"
      :for="getId"
    >
      {{ form.label }}
    </label>
    <div class="col-md-9">
      <text-form
        v-if="form.type === 'text'"
        :form="form"
        :value="value"
        @input="$emit('input', $event)"
      />
      <password-form
        v-else-if="form.type === 'password'"
        :form="form"
        :value="value"
        @input="$emit('input', $event)"
      />
      <checkbox-form
        v-else-if="form.type === 'checkbox'"
        :form="form"
        :value="value"
        @input="$emit('input', $event)"
      />
    </div>
    <div class="col-md-3" />
    <div class="col-md-9">
      <small
        v-if="form.desc"
        :id="getId"
        class="form-text text-muted"
      >{{ form.desc }}</small>
    </div>
  </div>
</template>

<script>
import TextForm from './TextForm';
import CheckboxForm from './CheckboxForm';
import PasswordForm from './PasswordForm';
import Mixin from './mixin';

export default {
  components: {
    TextForm, CheckboxForm, PasswordForm,
  },
  mixins: [Mixin],
};
</script>

<style scoped>

</style>
