<template>
  <v-runtime-template :template="wrapTemplateWithDiv" />
</template>

<script>
import VRuntimeTemplate from 'v-runtime-template';

export default {
  components: {
    VRuntimeTemplate,
  },
  props: ['template', 'field'],
  computed: {
    wrapTemplateWithDiv() {
      return `<div>${this.template}</div>`;
    },
  },
};
</script>

<style scoped>

</style>
