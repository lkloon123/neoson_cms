<template>
    <div style="height: 700px;">
        <file-manager></file-manager>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.$store.dispatch('fm/refreshAll');
            this.$store.commit('fm/setFileCallBack', null);
        },
        created() {
            this.$store.commit('SET_CURRENT_PAGE_TITLE', 'File Manager');
        }
    }
</script>

<style scoped>

</style>
