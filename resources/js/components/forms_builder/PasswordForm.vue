<template>
  <input
    :id="getId"
    :aria-describedby="getId"
    :value="value"
    class="form-control"
    type="password"
    @input="$emit('input', $event.target.value)"
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
