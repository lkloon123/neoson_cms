<template>
  <card
    :is-collapsible="true"
    class="mb-1"
  >
    <template v-slot:header>
      <h4>{{ title }}</h4>
    </template>

    <slot />
  </card>
</template>

<script>
import Card from '@components/Card';

export default {
  components: {
    Card,
  },
  props: {
    title: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>

</style>
