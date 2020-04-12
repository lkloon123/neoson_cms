<template>
  <div
    class="cursor-pointer"
    @click="goToUser"
  >
    <statistic-card :header="$t('dashboard.total_users')">
      <template v-slot:icon>
        <i class="fas fa-user" />
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
  mounted() {
    this.loadPagesCount();
  },
  methods: {
    async loadPagesCount() {
      this.isLoading = true;

      const pagesCountResponse = await axios.get('/api/user/count');
      this.amount = pagesCountResponse.data.count;

      this.isLoading = false;
    },
    goToUser() {
      this.$router.push('/settings/users');
    },
  },
};
</script>

<style scoped>

</style>
