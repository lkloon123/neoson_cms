<template>
  <footer class="main-footer">
    <div class="footer-left">
      Copyright &copy; 2019
      <div class="bullet" />
      NeoSon
    </div>
    <div
      v-if="version"
      class="footer-right hidden-xs"
    >
      Version {{ version }}
    </div>
  </footer>
</template>

<script>
import axios from 'axios';

export default {
  data: () => ({
    version: null,
  }),
  created() {
    this.loadVersion();
  },
  methods: {
    async loadVersion() {
      const versionResponse = await axios.options('/api/version');
      this.version = versionResponse.data.version;
    },
  },
};
</script>

<style scoped>
    .main-footer {
        background-color: white;
        display: block;
        height: 60px;
        margin-top: 35px;
    }
</style>
