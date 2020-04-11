<template>
  <div class="fm-container">
    <file-manager />
  </div>
</template>

<script>
export default {
  mounted() {
    this.$store.dispatch('fm/refreshAll');
    this.$store.commit('fm/setFileCallBack', null);
  },
  created() {
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'menu.file_manager');
  },
};
</script>

<style scoped>
  .fm-container {
    height: 700px;
  }
</style>
