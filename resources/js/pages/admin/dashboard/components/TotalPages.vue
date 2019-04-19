<template>
    <div @click="goToPage" class="cursor-pointer">
        <statistic-card header="Total Pages">
            <template v-slot:icon>
                <i class="fas fa-file"></i>
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
                axios.get('/api/page/count')
                    .then(response => {
                        this.amount = response.data;
                    })
                    .finally(() => {
                        this.isLoading = false;
                    })
            },
            goToPage() {
                this.$router.push('/pages');
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
