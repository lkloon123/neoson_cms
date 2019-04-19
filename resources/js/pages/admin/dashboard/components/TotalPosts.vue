<template>
    <div @click="goToPost" class="cursor-pointer">
        <statistic-card header="Total Posts">
            <template v-slot:icon>
                <i class="fas fa-align-left"></i>
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
            isLoading: false
        }),
        methods: {
            loadPostsCount() {
                this.isLoading = true;
                axios.get('/api/post/count')
                    .then(response => {
                        this.amount = response.data;
                    })
                    .finally(() => {
                        this.isLoading = false;
                    })
            },
            goToPost() {
                this.$router.push('/posts');
            }
        },
        components: {
            StatisticCard
        },
        created() {
            this.loadPostsCount();
        }
    }
</script>

<style scoped>

</style>
