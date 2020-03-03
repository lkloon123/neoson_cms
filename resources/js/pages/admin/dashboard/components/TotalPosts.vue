<template>
  <div
    class="cursor-pointer"
    @click="goToPost"
  >
    <statistic-card header="Total Posts">
      <template v-slot:icon>
        <i class="fas fa-align-left" />
      </template>

      <template v-slot:body>
        <i
          v-if="isLoading"
          class="fas fa-spinner fa-pulse"
        />
        <span v-else>{{ amount }}</span>
      </template>
    </statistic-card>
  </div>
</template>

<script>
import StatisticCard from '@components/StatisticCard';
import axios from 'axios';

export default {
  components: {
    StatisticCard,
  },
  data: () => ({
    amount: 0,
    isLoading: false,
  }),
  created() {
    this.loadPostsCount();
  },
  methods: {
    async loadPostsCount() {
      this.isLoading = true;

      const postsCountResponse = await axios.get('/api/post/count');
      this.amount = postsCountResponse.data;

      this.isLoading = false;
    },
    goToPost() {
      this.$router.push('/posts');
    },
  },
};
</script>

<style scoped>

</style>
