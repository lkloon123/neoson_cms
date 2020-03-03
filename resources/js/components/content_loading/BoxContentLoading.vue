<template>
  <vue-content-loading :height="150">
    <rect
      x="0"
      y="0"
      rx="5"
      ry="5"
      width="400"
      height="150"
    />
  </vue-content-loading>
</template>

<script>
import VueContentLoading from 'vue-content-loading';

export default {
  components: {
    VueContentLoading,
  },
};
</script>

<style scoped>

</style>
