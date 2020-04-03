<template>
  <div
    class="cursor-pointer"
    @click="goToPage"
  >
    <statistic-card header="Total Pages">
      <template v-slot:icon>
        <i class="fas fa-file" />
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
    this.loadPagesCount();
  },
  methods: {
    async loadPagesCount() {
      this.isLoading = true;

      const pagesCountResponse = await axios.get('/api/page/count');
      this.amount = pagesCountResponse.data.count;

      this.isLoading = false;
    },
    goToPage() {
      this.$router.push('/pages');
    },
  },
};
</script>

<style scoped>

</style>
