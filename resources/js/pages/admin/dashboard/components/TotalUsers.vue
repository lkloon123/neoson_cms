<template>
    <div @click="goToUser" class="cursor-pointer">
        <statistic-card header="Total Users">
            <template v-slot:icon>
                <i class="fas fa-user"></i>
            </template>

            <template v-slot:body>
                <i class="fas fa-spinner fa-pulse" v-if="isLoading"></i>
                <span v-else>{{amount}}</span>
            </template>
        </statistic-card>
    </div>
</template>

<script>
    import StatisticCard from '@components/StatisticCard';

    export default {
        data: () => ({
            amount: 0,
            isLoading: false,
        }),
        methods: {
            loadPagesCount() {
                this.isLoading = true;
                axios.get('/api/user/count')
                    .then(response => {
                        this.amount = response.data;
                    })
                    .finally(() => {
                        this.isLoading = false;
                    })
            },
            goToUser() {
                this.$router.push('/settings/users');
            }
        },
        components: {
            StatisticCard
        },
        created() {
            this.loadPagesCount();
        }
    }
</script>

<style scoped>

</style>
