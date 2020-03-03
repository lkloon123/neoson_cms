<template>
  <div>
    <router-view />

    <div
      v-if="showLoader"
      class="loader_container"
    >
      <half-circle-spinner
        :animation-duration="1000"
        :size="60"
        :color="'#ff1d5e'"
      />
    </div>
  </div>
</template>

<script>
import { HalfCircleSpinner } from 'epic-spinners';

export default {
  components: {
    HalfCircleSpinner,
  },
  computed: {
    showLoader() {
      return this.$store.state.showLoader;
    },
  },
  mounted() {
    window.loading_screen.finish();
  },
};
</script>

<style scoped>
    .loader_container {
        position: fixed;
        display: block;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 99999;
        cursor: pointer;
    }

    .loader_container > .half-circle-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        font-size: 50px;
        color: white;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
    }
</style>
