<template>
  <v-runtime-template :template="template" />
</template>

<script>
import VRuntimeTemplate from 'v-runtime-template';
import { cloneDeep } from 'lodash';
import TranslationMixin from '@mixins/translation_mixin';

export default {
  components: {
    VRuntimeTemplate,
  },
  mixins: [TranslationMixin],
  props: {
    template: {
      type: String,
      required: true,
    },
    formItem: {
      type: Object,
      required: true,
    },
  },
  computed: {
    field() {
      const clonedFormItem = cloneDeep(this.formItem);
      clonedFormItem.inputWatcher = this.notifyValueChanged;
      clonedFormItem.submitWatcher = this.notifyOnSubmit;
      return clonedFormItem;
    },
  },
  methods: {
    notifyValueChanged(event) {
      this.$emit('value-changed', event.target.value);
    },
    notifyOnSubmit(event) {
      this.$emit('onSubmit', event);
    },
  },
};
</script>

<style scoped>

</style>
