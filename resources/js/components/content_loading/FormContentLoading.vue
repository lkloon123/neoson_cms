<template>
  <vue-content-loading :height="height">
    <template v-for="(amount, index) in formAmount">
      <div :key="index">
        <rect
          x="0"
          :y="getYPos(amount)"
          rx="5"
          ry="5"
          width="150"
          height="25"
        />
        <rect
          x="0"
          :y="getYPos(amount) + 45"
          rx="5"
          ry="5"
          width="400"
          height="50"
        />
      </div>
    </template>
  </vue-content-loading>
</template>

<script>
import VueContentLoading from 'vue-content-loading';

export default {
  components: {
    VueContentLoading,
  },
  props: {
    formAmount: {
      type: Number,
      default: 1,
    },
  },
  computed: {
    height() {
      return this.formAmount * 130;
    },
  },
  methods: {
    getYPos(row) {
      return (row - 1) * 140;
    },
  },
};
</script>

<style scoped>

</style>
