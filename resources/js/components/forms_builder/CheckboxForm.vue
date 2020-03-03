<template>
  <input
    :id="getId"
    :aria-describedby="getId"
    :checked="value"
    type="checkbox"
    @click="$emit('input', $event.target.checked)"
  >
</template>

<script>
import Mixin from './mixin';

export default {
  mixins: [Mixin],
};
</script>

<style scoped>

</style>
