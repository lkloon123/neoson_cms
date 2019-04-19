<template>
    <div>
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <total-pages></total-pages>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <total-posts></total-posts>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <total-users></total-users>
            </div>
        </div>
    </div>
</template>

<script>
    import TotalPages from './components/TotalPages';
    import TotalPosts from './components/TotalPosts';
    import TotalUsers from './components/TotalUsers';

    export default {
        components: {
            TotalPages, TotalPosts, TotalUsers
        },
        created() {
            this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Dashboard');
        }
    }
</script>

<style scoped>

</style>
