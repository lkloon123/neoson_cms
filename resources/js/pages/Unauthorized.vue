<template>
    <div class="container mt-5">
        <div class="page-error">
            <div class="page-inner">
                <h1>403</h1>
                <div class="page-description">
                    You do not have access to this page.
                </div>

                <div class="mt-3">
                    <router-link to="/dashboard" class="btn btn-info btn-lg btn-round" id="btnBack">
                        Back to Home
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            $('#btnBack').removeClass('active');
        },
        created() {
            this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Unauthorized');
        }
    }
</script>
